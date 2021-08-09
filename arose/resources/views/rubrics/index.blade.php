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
        @foreach($myrubrics as $data)
            <tr>
                <td colspan="3">
                    <a href="/rubrics/show/{{$data->id}}">
                        {{$data->title}}
                    </a>
                </td>
                <td class="text-right" colspan="2">
                    @php
                    $usedrubrictimes = count($data->usedrubrics);
                    @endphp
                    <a href="/rubrics/show/{{$data->id}}" class="btn btn-light btn-sm">
                        <i class="fa fa-eye"></i> View
                    </a>
                    @if ($user->id === $data->user_id && $usedrubrictimes == 0)
                    <a href="/rubrics/edit/{{$data->id}}" class="btn btn-light btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    @endif
                    <a href="/rubrics/duplicate/{{$data->id}}" class="btn btn-light btn-sm">
                        <i class="fa fa-copy"></i> Duplicate
                    </a>
                    @if ($user->id === $data->user_id && $usedrubrictimes == 0)
                    <a href="/rubrics/delete/{{$data->id}}" class="btn btn-light btn-sm">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="text-nowrap">{{$data->points}} points</td>
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
                <td class="text-right">
                    @if ($user->id === $data->user_id && $usedrubrictimes > 0)
                    <small class="text-nowrap text-danger">You can't edit or delete an used rubric</small>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {!! $myrubrics->links() !!}
        </div>
</div>
</div>
@endsection
