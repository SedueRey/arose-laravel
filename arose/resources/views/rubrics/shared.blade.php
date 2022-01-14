@extends('layouts.app')

@php
$user = \Auth::user();
@endphp
@section('content')
<div class="container bootstrap snippet">
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Arose project</a></li>
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Arose project shared Rubrics</li>
    </ol>
</nav>
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link" href="/rubrics">My {{$otherrubrics}} rubrics</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/aroserubrics">{{$myrubrics->total()}} Arose project shared rubrics</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="/#">{{$sharedrubrics->total()}} Instructors shared rubrics</a>
    </li>
</ul>
<div class="row">
    <div class="col-md-12">
        @if (count($sharedrubrics) ==  0)
        <div class="col-md-12 alert alert-warning" role="alert">
            Sorry, there are no shared rubrics yet.
        </div>
        @endif
        @if (session('message'))
        <div class="col-md-12 alert alert-info" role="alert">
            {{ session('message') }}
        </div>
        @endif
    <div class="table-responsive">
    <table class="table table-sm">
        <thead>
            <tr>
                <th class="text-nowrap">Title / Points</th>
                <th class="text-nowrap">Criteria</th>
                <th class="text-nowrap">Ratings</th>
                <th class="text-nowrap">Used in gradebooks</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($sharedrubrics as $data)
            <tr>
                <td colspan="3">
                    <a href="/rubrics/show/{{$data->id}}">
                        {{$data->title}}
                    </a>
                    <br />
                    <small>Shared by <em>{{$data->user->name}}</em></small>
                </td>
                <td class="text-right" colspan="2">
                    @php
                    $usedrubrictimes = count($data->usedrubrics);
                    @endphp
                    <a href="/rubrics/show/{{$data->id}}" class="btn btn-light btn-sm">
                        <i class="fa fa-eye"></i> View
                    </a>
                    <a href="/rubrics/duplicate/{{$data->id}}" class="btn btn-light btn-sm">
                        <i class="fa fa-copy"></i> Make a copy for me
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-nowrap">
                    {{$data->points}},
                    {{ $data->maxpoints ?? 0 }} max, pass with {{ $data->passpoints ?? 0 }}
                </td>
                <td class="text-nowrap">{{count($data->criteria)}} criteria</td>
                <td class="text-nowrap">
                    @php
                    $ratings = 0;
                    for($i = 0; $i < count($data->criteria); $i++) {
                        $ratings += count($data->criteria[$i]->ratings);
                    }
                    @endphp
                    {{ $ratings }} ratings
                </td>
                <td class="text-nowrap">
                    {{ $usedrubrictimes }} times
                </td>
                <td class="text-right"></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    </div>
        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {!! $sharedrubrics->links() !!}
        </div>
</div>
</div>
@endsection
