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

    public function myself(){
        $user_id = Auth()->user()->id;
        $user = User::findOrFail($user_id);
        return response()->json($user);
    }


    public function aroserubrics(){
        $aroseRubrics = Rubric::with('criteria.ratings', 'usedrubrics')
            ->where('user_id', 1)->get();
        return response()->json($aroseRubrics);
    }

    public function myrubrics(){
        $user_id = Auth()->user()->id;

        $myRubrics = Rubric::with('criteria.ratings', 'usedrubrics')
            ->where('user_id', $user_id)->get();

        return response()->json($myRubrics);
    }

    public function mystudents(){
        $user_id = Auth()->user()->id;
        $myStudents = Student::where('user_id', $user_id)->get();
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
            Usedrubric::where([
                ['rubric_id', '=', $request->rubricId],
                ['user_id', '=', $user_id],
                ['level', '=', ''],
            ])->delete();
            return response()->json('ok');
        }
    }

    public function setuserstudentusedrrating(Request $request){
        dd($request);
    }
}
