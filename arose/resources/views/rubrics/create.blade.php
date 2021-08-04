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
          <li class="breadcrumb-item active" aria-current="page">Create Rubric</li>
        </ol>
    </nav>
    <form method="POST" action="{{route('storeRubric')}}">
        @csrf
        <h1 class="h3">Create Rubric</h1>
        <rubric-form :old="{{ json_encode(Session::getOldInput(), JSON_FORCE_OBJECT) }}"></rubric-form>
        <button type="submit">Save rubric</button>
    </form>
    <pre>{{ json_encode(Session::getOldInput(), JSON_FORCE_OBJECT) }}</pre>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="/jsdev/rubrics.js" defer></script>
@endsection
