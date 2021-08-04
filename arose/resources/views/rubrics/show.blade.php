@extends('layouts.app')

@section('content')

<div class="container bootstrap snippet">
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Arose project</a></li>
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/rubrics">My Rubrics</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail: {{ substr($rubric->title, 0, 10) }}&hellip;</li>
    </ol>
</nav>
<div class="px-0 py-0 mx-auto">
    <h1 class="h3">{{ucfirst($rubric->title)}}</h1>
</div>
@if (isset($message))
<div class="row">
    <div class="col-md-12 alert alert-info" role="alert">
        {{ $message }}
    </div>
</div>
@endif
<div class="row">
    <div class="col-md-12 pb-0">
        @if ( count($rubric->criteria) == 1 )
        {{ count($rubric->criteria) }} criterion,
        @else
        {{ count($rubric->criteria) }} criteria,
        @endif
        {{ $rubric->points }} points
    </div>
</div>
<hr />
@foreach($rubric->criteria as $criterion)
<div class="row">
    <section class="col-md-12 mb-4">
        <h2 class="h5">
            Criterion: {{ $criterion->title }}
        </h2>
        <p>
            {{ $criterion->description }}<br>
            <em><small>{{ count($criterion->ratings) }} ratings</small></em>
        </p>
        @if (count($criterion->ratings) > 0)
        <ul class="showratings">
            @foreach($criterion->ratings as $rating)
            <li class="showratings__item">
                <em class="showratings__points float-right">
                    <strong class="text-primary">{{$rating->points}}</strong>
                    points
                </em>
                <h3 class="h5">{{$rating->title}}</h3>
                <p>{{$rating->description}}</p>
            </li>
            @endforeach
        </ul>
        @endif
    </section>
</div>
@endforeach
@endsection
