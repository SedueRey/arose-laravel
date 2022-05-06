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
        <a class="nav-link" href="/gradebook/config">Gradebook configuration</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/gradebook/stats">Grade stats</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/gradebook/summary">Student Graded summary</a>
    </li>
</ul>
<section class="gradebookapp">
<p class="text-right">
    <a href="/gradebook/excel" class="btn btn-sm btn-primary" download>
        <i class="fas fa-file-excel"></i>
        &nbsp;&nbsp;Export as Excel
    </a>
</p>
<student-grading></student-grading>
</section>
@endsection
