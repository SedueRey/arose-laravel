@extends('layouts.app')

@section('content')

@php
$user = \Auth::user();
if(!isset($level)) {
    $level = 'all';
}
if(!isset($format)) {
    $format = 'all';
}
@endphp
<div class="container">
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">Arose Resources for teachers</h1>
      <p class="lead">Lorem ipsum dolor sit amet.</p>
    </div>
    <div class="row">
        <aside class="col-lg-4 col-md-6">
        <ul class="list-group">
            <li class="list-group-item">
                <h6>Search resources:</h6>
                <form action="/resources/search" method="POST" class="form-inline mt-2 mt-md-0">
                    @csrf
                    <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search">
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
                </form>
            </li>
            <li class="list-group-item">
                <a href="/resources/">Clear all filters</a>
            </li>
            <li class="list-group-item">
                <h6>Filter by level:</h6>
                <a href="/resources/filter/{{$format}}/all">No filter</a><br>
                <a href="/resources/filter/{{$format}}/A2">A2</a><br>
                <a href="/resources/filter/{{$format}}/B2">B2</a>
            </li>
            <li class="list-group-item">
                <h6>Filter by format:</h6>
                <a href="/resources/filter/all/{{$level}}/">No filter</a><br>
                <a href="/resources/filter/Text/{{$level}}">Text</a><br>
                <a href="/resources/filter/Audio/{{$level}}">Audio</a><br>
                <a href="/resources/filter/Video/{{$level}}">Video</a><br>
                <a href="/resources/filter/Multimedia/{{$level}}">Multimedia</a>
            </li>
        </ul>
        </aside>
        <section class="col-lg-8 col-md-6">
        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {!! $resourceData->links() !!}
        </div>
            <div class="row">
    @if ($resourceData->count() ==  0)
    <div class="col-md-12 alert alert-warning" role="alert">
    Sorry, there are no results for this search.
    </div>
    @endif
    @if($level !== 'all')
    <div class="col-md-12 alert alert-dark" role="alert">
        Filtering by level: <strong>{{strtoupper($level)}}</strong>. <a href="/resources/">Clear all filters</a>
    </div>
    @endif
    @if($format !== 'all')
    <div class="col-md-12 alert alert-dark" role="alert">
        Filtering by format: <strong>{{ucfirst($format)}}</strong>. <a href="/resources/">Clear all filters</a>
    </div>
    @endif
    @foreach($resourceData as $data)
    <div class="col-lg-6">
    <article class="card card-arose">
        <div class="card-body">
            <div class="row p-3">
                <div class="col-12">
                    <h5>
                        <a href="{{$data->filepath}}">{{$data->filename}}</a>
                    </h5>
                    <p>{{ ucfirst($data->type)}}</p>
                    <hr>
                    <p>
                        <a href="/resources/filter/{{$format}}/{{$data->level}}" class="badge badge-secondary">{{$data->level}}</a>
                        <a href="/resources/filter/{{$data->format}}/{{$level}}" class="badge badge-secondary">{{$data->format}}</a>
                    </p>
                    @auth
                    @if($user->id == $data->uploaded_by)
                    <p>
                        <a href="/resources/edit/{{$data->id}}" class="btn btn-light btn-sm">Edit</a>
                    </p>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
    </article>
    </div>
    @endforeach
    </div>
        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {!! $resourceData->links() !!}
        </div>
    </section>
    </div>

</div>
@endsection
