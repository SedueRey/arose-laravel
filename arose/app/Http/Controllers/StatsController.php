<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index() {
        $user_id = Auth()->user()->id;
        $maxRubricPointsQuery = "
        SELECT rb.id as rubricid, rb.title AS rubric_title, SUM(tmp.points) AS max_rubric_points
        FROM rubrics rb, criteria c, usedrubrics ur,
            (
            SELECT r.criterion_id AS criterion_id, MAX(r.points) AS points
            FROM ratings r
            GROUP BY r.criterion_id
            ) tmp
        WHERE c.rubric_id = rb.id
          AND tmp.criterion_id = c.id
          AND ur.rubric_id = rb.id
          AND ur.user_id = ?
        GROUP BY rubricid;
        ";
        $maxRubricPoints = DB::select($maxRubricPointsQuery, [$user_id]);

        $levelPointRubricQuery = "
        SELECT s.`level`, s.class, s.`group`, SUM(r.points) AS points, r.id AS ratingid, r.criterion_id AS criterionid, c.rubric_id, rb.title, COUNT(s.id) AS num_students
        FROM rating_student rs, ratings r, students s, criteria c, rubrics rb
        WHERE rs.rating_id = r.id
          AND rs.student_id = s.id
          AND c.id = r.criterion_id
          AND rb.id = c.rubric_id
          AND s.user_id = ?
        GROUP BY c.rubric_id, s.`level`
        ORDER BY s.`level`, rb.title, points DESC;
        ";
        $levelPointRubric = DB::select($levelPointRubricQuery, [$user_id]);

        $groupPointRubricQuery = "
        SELECT s.`level`, s.class, s.`group`, SUM(r.points) AS points, r.id AS ratingid, r.criterion_id AS criterionid, c.rubric_id, rb.title, COUNT(s.id) AS num_students
        FROM rating_student rs, ratings r, students s, criteria c, rubrics rb
        WHERE rs.rating_id = r.id
          AND rs.student_id = s.id
          AND c.id = r.criterion_id
          AND rb.id = c.rubric_id
          AND s.user_id = ?
        GROUP BY c.rubric_id, s.`group`
        ORDER BY s.`group`, rb.title, points DESC;
        ";
        $groupPointRubric = DB::select($groupPointRubricQuery, [$user_id]);

        $classPointRubricQuery = "
        SELECT s.`level`, s.class, s.`group`, SUM(r.points) AS points, r.id AS ratingid, r.criterion_id AS criterionid, c.rubric_id, rb.title, COUNT(s.id) AS num_students
        FROM rating_student rs, ratings r, students s, criteria c, rubrics rb
        WHERE rs.rating_id = r.id
          AND rs.student_id = s.id
          AND c.id = r.criterion_id
          AND rb.id = c.rubric_id
          AND s.user_id = ?
        GROUP BY c.rubric_id, s.`class`
        ORDER BY s.`class`, rb.title, points DESC;
        ";
        $classPointRubric = DB::select($classPointRubricQuery, [$user_id]);

        $studentPointsListQuery = "
        SELECT COUNT(tmp.id) AS num_students, tmp.every_total
        FROM (
        SELECT s.id, SUM(r.points) AS every_total
        FROM rating_student rs, students s, ratings r
        WHERE s.id = rs.student_id
            AND rs.rating_id = r.id
            AND s.user_id = ?
        GROUP BY s.id
        ) tmp
        GROUP BY tmp.every_total
        ORDER BY tmp.every_total DESC;
        ";

        $studentPointsList = DB::select($studentPointsListQuery, [$user_id]);

        $data = [
            'maxRubricPoints' => $maxRubricPoints,
            'levelPointRubric' => $levelPointRubric,
            'groupPointRubric' => $groupPointRubric,
            'classPointRubric' => $classPointRubric,
            'studentPointsList' => $studentPointsList,
        ];
        // dd($data);
        return view('stats.stats', $data);
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
            SELECT rb.id, rb.title AS rubric_title, rb.id AS rubric_id,
                   rb.maxpoints, rb.passpoints,
                   COUNT(c.id) AS colspan_rubric
            FROM rubrics rb, criteria c, usedrubrics u
            WHERE c.rubric_id = rb.id
              AND u.rubric_id = rb.id
              AND u.user_id   = ?
            GROUP BY c.rubric_id
            ORDER BY rb.id
        ";
        $rubricData = DB::select($rubricQuery, [$user_id]);
        $criteriaRatingQuery = "
        SELECT
            rb.id as rubric_id,
            c.title AS criterion_title, c.id AS criterion_id,
            COUNT(r.id) AS colspan_criteria
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
        // dd($data);
        return view('stats.excel', $data);
        // $filename = 'StudentGrading-'. str_replace('+','-', urlencode(Auth()->user()->name)).'.xls';
        // return response()->view('gradebook.excel', $data);
    }

}
