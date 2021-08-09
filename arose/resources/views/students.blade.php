@extends('layouts.app')

@section('content')

@php
$user = \Auth::user();
$photo = $user->photo;
@endphp
<div class="container">
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Arose project</a></li>
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">My students</li>
    </ol>
</nav>
<div class="px-0 py-0 pt-md-5 pb-md-4 mx-auto">
    <h1 class="display-5">My students</h1>
</div>
<div class="row">
    <p>
        <a href="/students/new" class="btn btn-primary">Add new student</a>
    </p>
    @if (count($studentData) ==  0)
    <div class="col-md-12 alert alert-warning" role="alert">
        Sorry, there are no students yet. You can add one
    </div>
    @else
    @if (session('message'))
    <div class="col-md-12 alert alert-info" role="alert">
        {{ session('message') }}
    </div>
    @endif
    <table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Class</th>
            <th>Group</th>
            <th>Level</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($studentData as $data)
        <tr>
            <td>{{$data->name}}</td>
            <td>{{$data->age}}</td>
            <td>{{$data->class}}</td>
            <td>{{$data->group}}</td>
            <td>{{$data->level}}</td>
            <td>
                <a href="/students/edit/{{$data->id}}" class="btn btn-light btn-sm">
                    <i class="fa fa-edit"></i> Edit
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>
    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {!! $studentData->links() !!}
    </div>
    @endif
</div>
@endsection
