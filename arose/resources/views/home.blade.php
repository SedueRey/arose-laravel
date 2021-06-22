@extends('layouts.app')

@section('content')

@php
$user = \Auth::user();
$photo = $user->photo;
@endphp
<div class="container">
<div class="row">
<div class="col-md-3">
  <div class="profile-sidebar px-3">
    <!-- SIDEBAR USERPIC -->
    <div class="profile-userpic text-center">
        @if ($user->photo)
        <img src="{{ asset('/storage/avatar/'.$photo) }}" class="img-responsive" alt="avatar">
        @else
        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png"  class="img-responsive" alt="avatar">
        @endif
    </div>
    <!-- END SIDEBAR USERPIC -->
    <!-- SIDEBAR USER TITLE -->
    <div class="profile-usertitle">
      @if($user->name)
      <div class="profile-usertitle-name">
        {{$user->name}}
      </div>
      @else
      <div class="profile-usertitle-job">
        We don't know you yet. Please fill <a href="/profile">your profile</a> in.
      </div>
      @endif
      <div class="profile-usertitle-job">
      {{$user->school}}<br>
      @if ($user->city)
        {{$user->city ?: '' }},
      @endif
      {{$user->country}}<br>
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
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 py-3">
                    <a href="#" class="card">
                        <div class="card-body text-center">
                            <h1 class="p-3 text-primary"><i class="fa fa-2x fa-signature"></i></h1>
                        </div>
                        <div class="card-footer text-center">0 Rubrics</div>
                    </a>
                </div>
                <div class="col-sm-4 py-3">
                    <a href="/students" class="card">
                        <div class="card-body text-center">
                            <h1 class="p-3 text-danger"><i class="fa fa-2x fa-user-graduate"></i></h1>
                        </div>
                        <div class="card-footer text-center">{{$user->students()->count()}} Students</div>
                    </a>
                </div>
                <div class="col-sm-4 py-3">
                    <a href="/resources/mine" class="card">
                        <div class="card-body text-center">
                            <h1 class="p-3 text-success"><i class="fa fa-2x fa-folder"></i></h1>
                        </div>
                        <div class="card-footer text-center">{{$user->resources()->count()}} Resources</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
