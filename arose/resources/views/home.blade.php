@extends('layouts.app')

@section('content')

@php
$user = \Auth::user();
@endphp
<div class="container">
<div class="row">
<div class="col-md-3">
  <div class="profile-sidebar">
    <!-- SIDEBAR USERPIC -->
    <div class="profile-userpic text-center">
        <img src="{{ asset('/storage/avatar/01.jpg) }}" class="img-responsive" alt="avatar">
        @if ($user->photo)
        <img src="{{ asset('/storage/avatar/'.Auth::user()->photo) }}" class="img-responsive" alt="avatar">
        @else
        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png"  class="img-responsive" alt="avatar">
        @endif
    </div>
    <!-- END SIDEBAR USERPIC -->
    <!-- SIDEBAR USER TITLE -->
    <div class="profile-usertitle">
      <div class="profile-usertitle-name">
      {{$user->name}}
      </div>
      <div class="profile-usertitle-job">
      {{$user->school}}<br>
      {{$user->city ?: ''}}, {{$user->country}}<br>
      </div>
    </div>
    <div class="profile-biography text-center">
    {{substr($user->biography, 0, 32)}}...
    </div>
    <!-- END MENU -->
  </div>
</div>
<div class="col-9">
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
</div>
</div>
@endsection
