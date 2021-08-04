@extends('layouts.app')

@section('content')

@php
$user = \Auth::user();
@endphp
<div class="container bootstrap snippet">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Arose project</a></li>
          <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="/rubrics">My Rubrics</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit Rubric</li>
        </ol>
    </nav>
    <form method="POST" action="{{route('updateRubric', ['id' => $rubric['id']])}}">
        @csrf
        <h1 class="h3">Edit Rubric</h1>
        <rubric-form :old="{{ json_encode($rubric) }}"></rubric-form>
        <button class="btn btn-primary btn-sm" type="submit">Edit rubric</button>
    </form>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="/jsdev/rubrics.js" defer></script>
@endsection
