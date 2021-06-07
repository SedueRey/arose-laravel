@extends('layouts.app')

@section('content')

@php
$user = \Auth::user();
@endphp
<div class="container">
<div class="card">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 d-flex bg-success p-5">
            <h1 class="mx-auto align-self-center"><i class="fas fa-chalkboard-teacher"></i></h1>
        </div>
        <div class="col-md-8 py-3">
            <h3 class="card-title">Arose webtool private app</h3>
            <p class="card-text">With supporting roots below as a natural lead-in to additional content and then some more content that is here.</p>
            <a href="#" class="btn btn-outline-success btn-block">Outline</a>
        </div>
    </div>

</div>
</div>
<div class="card my-3">
<div class="container-fluid">
    <div class="row bg-info py-5">
        <div class="col-3 mx-auto">
            <img class="rounded-circle img-fluid" src="//api.randomuser.me/portraits/men/73.jpg" alt="person">
        </div>
        <div class="col-12 text-center">
            <h3>{{$user->name}}</h3>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12 py-3">
            <p>Horton started at ACME 4 years ago and, is a pooch pooch with clever lyrics. This is a card.</p>
        </div>
    </div>
</div>
</div>
</div>
@endsection
