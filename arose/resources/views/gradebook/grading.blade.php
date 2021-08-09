@extends('layouts.app')

@section('content')

@php
$user = \Auth::user();
$photo = $user->photo;
@endphp
<div class="container gradebook">
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Arose project</a></li>
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Gradebook / Grading</li>
    </ol>
</nav>
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link active" href="#">Gradebook</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/gradebook/config">Gradebok configuration</a>
    </li>
</ul>
<section class="gradebookapp">
<student-grading></student-grading>
</section>
@endsection
