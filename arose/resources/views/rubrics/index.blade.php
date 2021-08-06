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
        <li class="breadcrumb-item active" aria-current="page">My Rubrics</li>
    </ol>
</nav>
<div class="px-0 py-0 pt-md-5 pb-md-4 mx-auto">
    <h1 class="display-5">My rubrics</h1>
</div>
<div class="row">
    <p>
        <a href="/rubrics/new" class="btn btn-primary">Add new rubric</a>
    </p>
    @if (count($myrubrics) ==  0)
    <div class="col-md-12 alert alert-warning" role="alert">
        Sorry, there are no rubrics yet. You can add one
    </div>
    @endif
    @if (isset($message))
    <div class="col-md-12 alert alert-info" role="alert">
        {{ $message }}
    </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th class="text-nowrap">Title</th>
                <th class="text-nowrap">Points</th>
                <th class="text-nowrap">Criteria</th>
                <th class="text-nowrap">Used in gradings</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($myrubrics as $data)
            <tr>
                <td>
                    <a href="/rubrics/show/{{$data->id}}">
                        {{$data->title}}
                    </a>
                </td>
                <td class="text-nowrap">{{$data->points}}</td>
                <td class="text-nowrap">{{count($data->criteria)}}</td>
                <td class="text-nowrap">0 times</td>
                <td class="text-right">
                    <a href="/rubrics/show/{{$data->id}}" class="btn btn-light btn-sm">
                        <i class="fa fa-eye"></i> View
                    </a>
                    @if ($user->id === $data->user_id)
                    <a href="/rubrics/edit/{{$data->id}}" class="btn btn-light btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    @endif
                    <a href="/rubrics/duplicate/{{$data->id}}" class="btn btn-light btn-sm">
                        <i class="fa fa-copy"></i> Duplicate
                    </a>
                    @if ($user->id === $data->user_id)
                    <a href="/rubrics/delete/{{$data->id}}" class="btn btn-light btn-sm">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
        </table>
        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {!! $myrubrics->links() !!}
        </div>
</div>
</div>
@endsection