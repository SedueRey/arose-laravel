@extends('layouts.app')

@section('contentfluid')

@php
$rubricRow = '';
$criteriaRow = '';
$ratingRow = '';
$students = [];
$studentRows = [];
foreach ($studentData as $key => $student) {
    $students[$student->id][0] = $student->name;
    $students[$student->id][1] = $student->surname;
    $students[$student->id][2] = $student->level;
    $students[$student->id][3] = $student->class;
    $students[$student->id][4] = $student->group;
    $students[$student->id][5] = $student->age;
}
$nextCol = 6;
foreach ($rubricData as $key => $rubric) {
    $criteria = array_filter($criteriaRatingData, function($obj) use ($rubric) {
        return ($obj->rubric_id === $rubric->id);
    });
    $howmuchcriteria = 0;
    foreach ($criteria as $key => $criterion) {
        $howmuchcriteria += $criterion->colspan_criteria;
        $criteriaRow .= "<th colspan=\"$criterion->colspan_criteria\">$criterion->criterion_title</th>";
        $ratings = array_filter($ratingData, function($obj) use ($criterion) {
            return ($obj->criteria_id === $criterion->criterion_id);
        });
        foreach ($ratings as $key => $rating) {
            $ratingRow .= "<th>$rating->rating_title (max $rating->rating_points)</th>";
            foreach ($students as $student_id => $student) {
                $student_rating = array_filter($gradingData, function($obj) use ($rating, $student_id){
                    return $rating->id === $obj->rating_id
                        && $obj->student_id === $student_id;
                });
                if (count($student_rating) === 0) {
                    $students[$student_id][$nextCol] = 0;
                } else {
                    $students[$student_id][$nextCol] = $rating->rating_points;
                }
            }
            $nextCol++;
        }
    }
    $rubricMaxPoints = "";
    if (isset($rubric->maxpoints) && ($rubric->maxpoints > 0) ) {
        $rubricMaxPoints = "(max. $rubric->maxpoints)";
    }
    $rubricPassPoints = "";
    if (isset($rubric->passpoints) && ($rubric->passpoints > 0) ) {
        $rubricPassPoints = "(pass. $rubric->passpoints)";
    }
    $rubricRow .= "<th colspan=\"$howmuchcriteria\">
        $rubric->rubric_title $rubricMaxPoints $rubricPassPoints
    </th>";
}
foreach ($students as $key => $value) {
    $content = '<tr>';
    $index = 0;
    $max = 0;
    $nonblanks = false;
    foreach ($value as $td) {
        $index++;
        if (is_numeric($td) && $td != 0 && $index != 6) {
            $content .= '<td class="bg-info text-white" style="text-align: center">'.$td.'</td>';
            $max = $max + intval($td);
            $nonblanks = true;
        } else if (is_numeric($td)){
            $content .= '<td style="text-align: center;">'.$td.'</td>';
        } else {
            $content .= '<td>'.$td.'</td>';
        }
    }
    if ($max > 0) {
        $content .= '<td class="bg-success text-white" style="text-align: center">'.$max.'</td>';
    } else {
        $content .= '<td style="text-align: center;">'.$max.'</td>';
    }
    $content .= '</tr>';
    // $studentRows[] = '<tr><td>'.implode('</td><td>', $value).'</td></tr>';
    if ($nonblanks) {
        $studentRows[] = $content;
    }
}
@endphp
<div class="container gradebook">
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Arose project</a></li>
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Gradebook / Summary</li>
    </ol>
</nav>
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link" href="/gradebook/">Gradebook</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/gradebook/config">Gradebook configuration</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/gradebook/stats">Grade stats</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="#">Student Graded summary</a>
    </li>
</ul>
<h1 class="display-6">Graded students</h1>
<p class="lead">Students to whom a grade has not been added will not appear in this list.</p>
</div>
<hr />
<div class="table-responsive">
<table class="table table-striped table-bordered" style="font-size: 0.75rem;">
    <thead style="background-color: #DEDEDE">
        <tr><th colspan="6"></th>{!! $rubricRow !!}<th></th></tr>
        <tr><th colspan="6">Student data</th>{!! $criteriaRow !!}<th></th></tr>
        <tr>
            <th>Given Name</th>
            <th>Family Name</th>
            <th>Level</th>
            <th>Class</th>
            <th>Group</th>
            <th>Age</th>
            {!! $ratingRow !!}
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        {!! implode('', $studentRows) !!}
    </tbody>
</table>
</div>

@endsection
