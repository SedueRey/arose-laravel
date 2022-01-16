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
    $studentRows[] = '<tr><td>'.implode('</td><td>', $value).'</td></tr>';
}
@endphp
<table border="1">
    <thead>
        <tr><th colspan="6"></th>{!! $rubricRow !!}</tr>
        <tr><th colspan="6">Student data</th>{!! $criteriaRow !!}</tr>
        <tr>
            <th>Given Name</th>
            <th>Family Name</th>
            <th>Level</th>
            <th>Class</th>
            <th>Group</th>
            <th>Age</th>
            {!! $ratingRow !!}
        </tr>
    </thead>
    <tbody>
        {!! implode('', $studentRows) !!}
    </tbody>
</table>
