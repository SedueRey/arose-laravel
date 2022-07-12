@extends('layouts.app')

@php
$rubricid = 1;
$maxpoints = [];
foreach ($maxRubricPoints as $rubricValue) {
    $maxpoints[$rubricValue->rubricid] = $rubricValue->max_rubric_points;
}

$maxStudentPoints = 0;
$maxStudentMax = 0;
$maxTotalStudents = 0;
foreach ($studentPointsList as $item) {
    if ($maxStudentPoints < $item->every_total) {
        $maxStudentPoints = $item->every_total;
    }
    if ($maxStudentMax < $item->num_students) {
        $maxStudentMax = $item->num_students;
    }
    $maxTotalStudents = $maxTotalStudents + $item->num_students;
}

@endphp

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Arose project</a></li>
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Gradebook / Stats</li>
    </ol>
</nav>
<div class="container gradebook">
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link" href="/gradebook/">Gradebook</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/gradebook/config">Gradebook configuration</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="#">Grade stats</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/gradebook/summary">Student Graded summary</a>
    </li>
</ul>
</div>
<h1>Student grades statistics</h1>
<hr />
<div class="d-none d-sm-block mb-5"></div>
<div class="row">
    <div class="col-md-6 mb-5">
        <h3>Points earned by students</h3>
        <div class="mt-4">
        @foreach ($studentPointsList as $points)
            <div>
                <progress style="vertical-align: middle; width: 7rem"
                    max="{{ $maxTotalStudents }}"
                    value="{{ $points->num_students }}"
                ></progress>
                {{ $points->every_total }} points,
                @if ($points->num_students == 1)
                {{ $points->num_students }} student
                @else
                {{ $points->num_students }} students
                @endif
                <span class="text-primary">
                    <strong>
                        {{ number_format($points->num_students / $maxTotalStudents * 100, 2) }}%
                    </strong>
                </span>
            </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-6 mb-5">
        <h3>Rubric points by level</h3>
        @php
            $lastHx = '';
            $showHx = false;
        @endphp
        @foreach($levelPointRubric as $data)
        @php
            if ($data->level != $lastHx) {
                $lastHx = $data->level;
                $showHx = true;
            } else {
                $showHx = false;
            }
        @endphp
        @if ( $showHx )
        <h5 class="mt-4">Level: {{ $data->level }}</h5>
        @endif
        <div>
            <progress
                style="vertical-align: middle; width: 7rem"
                max="{{ $maxpoints[$data->rubric_id] * $data->num_students }}"
                value="{{ $data->points }}">
                {{ number_format($data->points / ($maxpoints[$data->rubric_id] * $data->num_students) * 100, 2) }}%
            </progress>
            Rubric: {{ $data->title }}
            <small>
                ( {{ $data->points }} points of {{ $maxpoints[$data->rubric_id] * $data->num_students }} ),
                <span class="text-primary">
                    <strong>
                        {{ number_format($data->points / ($maxpoints[$data->rubric_id] * $data->num_students) * 100, 2) }}%
                    </strong>
                </span>
            </small>
        </div>
        @endforeach
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-5">
        <h3>Rubric points by group</h3>
        @php
            $lastHx = '';
            $showHx = false;
        @endphp
        @foreach($groupPointRubric as $data)
        @php
            if ($data->group != $lastHx) {
                $lastHx = $data->group;
                $showHx = true;
            } else {
                $showHx = false;
            }
        @endphp
        @if ( $showHx )
        <h5 class="mt-4">Group: {{ ucfirst($data->group) }}</h5>
        @endif
        <div>
            <progress
                style="vertical-align: middle; width: 7rem"
                max="{{ $maxpoints[$data->rubric_id] * $data->num_students }}"
                value="{{ $data->points }}">
                {{ number_format($data->points / ($maxpoints[$data->rubric_id] * $data->num_students) * 100, 2) }}%
            </progress>
            Rubric: {{ $data->title }}
            <small>
                ( {{ $data->points }} points of {{ $maxpoints[$data->rubric_id] * $data->num_students }} ),
                <span class="text-primary">
                    <strong>
                        {{ number_format($data->points / ($maxpoints[$data->rubric_id] * $data->num_students) * 100, 2) }}%
                    </strong>
                </span>
            </small>
        </div>
        @endforeach
    </div>
    <div class="col-md-6 mb-5">
        <h3>Rubric points by class</h3>
        @php
        $lastHx = 'sinclaseestablecida';
        $showHx = false;
        @endphp
        @foreach ($classPointRubric as $data)
            @php
                if ($data->class != $lastHx) {
                    $lastHx = $data->class;
                    $showHx = true;
                } else {
                    $showHx = false;
                }
            @endphp
            @if ($showHx)
                <h5 class="mt-4">Class:
                    @if (trim($data->class) != "")
                        {{ ucfirst($data->class) }}
                    @else
                        <em>Class with no name</em>
                    @endif
                </h5>
            @endif
            <div>
                <progress style="vertical-align: middle; width: 7rem"
                    max="{{ $maxpoints[$data->rubric_id] * $data->num_students }}" value="{{ $data->points }}">
                    {{ number_format(($data->points / ($maxpoints[$data->rubric_id] * $data->num_students)) * 100, 2) }}%
                </progress>
                Rubric: {{ $data->title }}
                <small>
                    ( {{ $data->points }} points of {{ $maxpoints[$data->rubric_id] * $data->num_students }} ),
                    <span class="text-primary">
                        <strong>
                            {{ number_format(($data->points / ($maxpoints[$data->rubric_id] * $data->num_students)) * 100, 2) }}%
                        </strong>
                    </span>
                </small>
            </div>
        @endforeach
    </div>
</div>
@endsection
