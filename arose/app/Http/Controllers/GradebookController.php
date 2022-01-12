<?php

namespace App\Http\Controllers;

use App\Models\Rubric;
use App\Models\Criterion;
use App\Models\Rating;
use App\Models\Student;
use App\Models\User;
use App\Models\Usedrubric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradebookController extends Controller
{
    public function index() {
        $user_id = Auth()->user()->id;
        $rubrics = Usedrubric::where('user_id', $user_id)->get();
        if (count($rubrics) == 0 ) {
            return redirect('/gradebook/config')->with('message', 1);
        }
        return view('gradebook.grading');
    }

    public function config() {
        return view('gradebook.config');
    }

    public function excel() {
        $user_id = Auth()->user()->id;
        $queryGrading = "
        SELECT
        s.id AS student_id,
        r.id AS rating_id, r.points AS criteria_points
        FROM students s, ratings r, rating_student rs
        WHERE r.id = rs.rating_id
          AND s.id = rs.student_id
          AND s.user_id = ?
        ORDER BY r.id ASC
        ";
        $gradingData = DB::select($queryGrading, [$user_id]);
        $studentQuery = 'SELECT * FROM students s WHERE s.user_id = ? ORDER BY s.surname, s.name';
        $studentData = DB::select($studentQuery, [$user_id]);
        $rubricQuery = "
            SELECT rb.id, rb.title AS rubric_title, rb.id AS rubric_id, COUNT(c.id) AS colspan_rubric
            FROM rubrics rb, criteria c, usedrubrics u
            WHERE c.rubric_id = rb.id
              AND u.rubric_id = rb.id
              AND u.user_id   = ?
            GROUP BY c.rubric_id
            ORDER BY rb.id
        ";
        $rubricData = DB::select($rubricQuery, [$user_id]);
        $criteriaRatingQuery = "
        SELECT rb.id as rubric_id, c.title AS criterion_title, c.id AS criterion_id, COUNT(r.id) AS colspan_criteria
        FROM rubrics rb, criteria c, usedrubrics u, ratings r
        WHERE c.rubric_id = rb.id
          AND u.rubric_id = rb.id
          AND r.criterion_id = c.id
          AND u.user_id = ?
        GROUP BY r.criterion_id
        ORDER BY c.id
        ";
        $criteriaRatingData = DB::select($criteriaRatingQuery, [$user_id]);
        $ratingQuery = "
        SELECT r.id, c.id as criteria_id, r.title AS rating_title, r.points as rating_points
        FROM rubrics rb, criteria c, usedrubrics u, ratings r
        WHERE c.rubric_id = rb.id
          AND u.rubric_id = rb.id
          AND r.criterion_id = c.id
          AND u.user_id = ?
        ORDER BY r.id
        ";
        $ratingData = DB::select($ratingQuery, [$user_id]);
        $data = [
            'gradingData' => $gradingData,
            'studentData' => $studentData,
            'rubricData' => $rubricData,
            'criteriaRatingData' => $criteriaRatingData,
            'ratingData' => $ratingData,
        ];
        // return view('gradebook.excel', $data);
        return response()
            ->view('gradebook.excel', $data)
            ->header('Content-disposition', 'attachment; filename=StudentGrading.xls')
            ->header('Content-Type', 'application/vnd.ms-excel');
    }

    public function myself(){
        $user_id = Auth()->user()->id;
        $user = User::findOrFail($user_id);
        return response()->json($user);
    }

    public function aroserubrics(){
        $aroseRubrics = Rubric::with('criteria.ratings.students', 'usedrubrics')
            ->where('user_id', 1)->get();

        for ($i=0; $i < count($aroseRubrics); $i++) {
            $aroseRubrics[$i]->isUsed = false;
            $aroseRubrics[$i]->students = 0;
            for ($j=0; $j < count($aroseRubrics[$i]->criteria); $j++) {
                for ($k=0; $k < count($aroseRubrics[$i]->criteria[$j]->ratings); $k++) {
                    $aroseRubrics[$i]->students = count($aroseRubrics[$i]->criteria[$j]->ratings[$k]->students) + $aroseRubrics[$i]->students;
                    unset($aroseRubrics[$i]->criteria[$j]->ratings[$k]->students);
                }
            }
            $aroseRubrics[$i]->isUsed = ($aroseRubrics[$i]->students > 0);
        }
        return response()->json($aroseRubrics);
    }

    public function myrubrics(){
        $user_id = Auth()->user()->id;
        $myRubrics = Rubric::with('criteria.ratings.students', 'usedrubrics')
            ->where('user_id', $user_id)->get();
        for ($i=0; $i < count($myRubrics); $i++) {
            $myRubrics[$i]->isUsed = false;
            $myRubrics[$i]->students = 0;
            for ($j=0; $j < count($myRubrics[$i]->criteria); $j++) {
                for ($k=0; $k < count($myRubrics[$i]->criteria[$j]->ratings); $k++) {
                    $myRubrics[$i]->students = count($myRubrics[$i]->criteria[$j]->ratings[$k]->students) + $myRubrics[$i]->students;
                    unset($myRubrics[$i]->criteria[$j]->ratings[$k]->students);
                }
            }
            $myRubrics[$i]->isUsed = ($myRubrics[$i]->students > 0);
        }
        return response()->json($myRubrics);
    }

    public function myusedrubrics() {
        $user_id = Auth()->user()->id;
        $myRubrics = Usedrubric::with('rubric.criteria.ratings')
        ->where('user_id', $user_id)->get();
        return response()->json($myRubrics);
    }

    public function mystudents(){
        $user_id = Auth()->user()->id;
        $myStudents = Student::with('ratings')
            ->where('user_id', $user_id)
            ->orderBy('surname')
            ->orderBy('name')->get();
        return response()->json($myStudents);
    }

    public function setuserusedrubric(Request $request){
        $user_id = Auth()->user()->id;
        if ($request->level == '') {
            Usedrubric::where([
                ['rubric_id', '=', $request->rubricId],
                ['user_id', '=', $user_id],
            ])->delete();

            Usedrubric::create([
                'rubric_id' => $request->rubricId,
                'user_id' => $user_id,
                'level' => '',
            ]);
            return response()->json('ok');
        }
    }

    public function removeuserusedrubric(Request $request){
        $user_id = Auth()->user()->id;
        if ($request->level == '') {

            $cuantos = DB::select("SELECT *
            FROM ratings rt, rubrics r, criteria c, rating_student rs
            WHERE rt.criterion_id = c.id
              AND c.rubric_id = r.id
              AND r.id = '".$request->rubricId."'
              AND r.user_id = '".$user_id."'
              AND rs.rating_id = rt.id");

            if (count($cuantos) == 0) {
                Usedrubric::where([
                    ['rubric_id', '=', $request->rubricId],
                    ['user_id', '=', $user_id],
                    ['level', '=', ''],
                ])->delete();
            }

            return response()->json('ok');
        }
    }

    public function setuserstudentusedrrating(Request $request){
        $user_id = Auth()->user()->id;
        $student = Student::with('ratings')->findOrFail($request->student_id);
        if ($student->user_id != $user_id) {
            abort(403, 'PERMISSION DENIED… YOU DIDN’T SAY THE MAGIC WORD!');
        }
        $student->ratings()->attach($request->rating_id);
        return response()->json('ok');
    }

    public function removeuserstudentusedrrating(Request $request){
        $user_id = Auth()->user()->id;
        $student = Student::with('ratings')->findOrFail($request->student_id);
        if ($student->user_id != $user_id) {
            abort(403, 'PERMISSION DENIED… YOU DIDN’T SAY THE MAGIC WORD!');
        }
        $student->ratings()->detach($request->rating_id);
        return response()->json('ok');
    }
}
