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
        <li class="breadcrumb-item active" aria-current="page">Gradebook / Config</li>
    </ol>
</nav>
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link" href="/gradebook/">Gradebook</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="#">Gradebook configuration</a>
    </li>
</ul>
@if (session('message'))
    <div class="row">
        <div class="col-md-12 alert alert-warning" role="alert">
            <strong>You do not have a rubric selected yet</strong> to grade your students.
            Select the rubrics, create one, or use the ones that the Arose project has shared.
        </div>
    </div>
    @endif
<div class="row">
    <config-grading class="col-md-12"></config-grading>
</div>
@endsection
