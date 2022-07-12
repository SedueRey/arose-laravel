@extends('layouts.app')

@section('content')

@php
$user = \Auth::user();
$photo = $user->photo;
@endphp
<div class="container">
<div class="row">
<div class="col-md-3 text-dark">
  <div class="profile-sidebar px-3">
    <!-- SIDEBAR USERPIC -->
    <a href="/profile" class="profile-userpic text-center">
        @if ($user->photo)
        <img src="{{ asset('/storage/avatar/'.$photo) }}" class="img-responsive mx-auto" alt="avatar">
        @else
        <img src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png"  class="img-responsive mx-auto" alt="avatar">
        @endif
    </a>
    <!-- END SIDEBAR USERPIC -->
    <!-- SIDEBAR USER TITLE -->
    <div class="profile-usertitle">
      @if($user->name)
      <a href="/profile" class="profile-usertitle-name">
        {{$user->name}}
      </a>
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
    <section class="py-2">
        <h2 class="pb-3">Arose webtool dashboard</h2>
        <div class="row">
            <div class="col-6">
                <img src="/img/study.svg" role="presentation" alt="Students" style="max-width: 100%; display:block;" class="mx-auto" />
            </div>
            <div class="col-6 pt-4 py-4">
                <p>This digital tool will be useful to assess oral skills in A2 and B2 levels in English. You can use all the AROSE resources and you will be able to share the new ones you can create.</p>
            </div>
        </div>
        <br>
        @if ( $user->isadmin )
        <aside class="alert alert-primary" role="alert">
          <h4>Admin Panel</h4>
          <a href="/arose/stats">Access to arose admin panel</a>
        </aside>
        @endif
        <h3 class="pt-4">What can you do from here?</h3>
        <p class="lead pb-2">Check all our tools:</p>
        <ol class="ol mx-0" style="list-style-type:none;">
            <li class="pb-4" style="position: relative">
                <span class="olnumber">1</span>
                <h3>
                    <a href="/resources">
                        <i class="fa fa-folder"></i>
                        Resources
                    </a>
                </h3>
                <p>At this moment, there are <strong>{{$resources}} <a href="/resources">Resources</a></strong> in the digital repository,
                    <a href="/resources/mine">{{$user->resources()->count()}} mine</a>. Browse them or add your own resources.</p>
            </li>
            <li class="pb-4" style="position: relative">
                <span class="olnumber">2</span>
                <h3>
                    <a href="/students">
                        <i class="fa fa-user-graduate text-primary"></i>
                        Students
                    </a>
                </h3>
                <p>It is necessary to add, first, the data of the <a href="/students">students</a> in order to be evaluated. You can start anytime from here. Right now, you have <strong>{{$user->students()->count()}} students</strong> added</p>
            </li>
            <li class="pb-4" style="position: relative">
                <span class="olnumber">3</span>
                <h3>
                    <a href="/rubrics">
                        <i class="fa fa-th" aria-hidden="true"></i>
                        Rubrics
                    </a>
                </h3>
                <p>Once you have added your students you should choose which rubrics you want to evaluate them with.  It can be as simple as a note or as elaborate as you need. You can also use <a href="/aroserubrics">the ones provided by the Arose project</a>, ({{$rubrics}} at this moment. <strong><a href="/rubrics">You have added {{$user->rubrics()->count()}}</a>.</strong></p>
            </li>
            <li class="pb-4" style="position: relative">
                <span class="olnumber">4</span>
                <h3>
                    <a href="/gradebook/config">
                        <i class="fa fa-book" aria-hidden="true"></i>
                        Config Gradebook
                    </a>
                </h3>
                <p>Before you can evaluate your students you must choose which of your own or shared rubrics you want to use.  You can do this from gradebook, on the Configure tab.</p>
            </li>
            <li class="pb-4" style="position: relative">
                <span class="olnumber">5</span>
                <h3>
                    <a href="/gradebook">
                        <i class="fa fa-book" aria-hidden="true"></i>
                        Grade Students on gradebook
                    </a>
                </h3>
                <p>And you can evaluate your students by selecting the values of the rubrics you have chosen.</p>
            </li>
        </ol>
    </section>
    <!--
    <div class="card">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 d-flex bg-success p-5">
                    <h1 class="mx-auto align-self-center"><i class="fas fa-chalkboard-teacher"></i></h1>
                </div>
                <div class="col-md-8 py-3">
                    <h3 class="card-title">Arose webtool private app</h3>
                    <p class="card-text">This is the area of the app where you can add the data you think you need to evaluate your students. </p>
                    <p class="card-text">
                        Once you have added the rubrics (you can use the ones that already exist in the system) you must create an evaluation sheet to be able to use them with your class..</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 py-3">
                    <a href="/rubrics" class="card">
                        <div class="card-body text-center">
                            <h1 class="p-3 text-info"><i class="fa fa-2x fa-signature"></i></h1>
                        </div>
                        <div class="card-footer text-center">
                            {{$rubrics}} Rubrics,
                            {{$user->rubrics()->count()}} mine
                        </div>
                    </a>
                </div>
                <div class="col-sm-4 py-3">
                    <a href="/students" class="card">
                        <div class="card-body text-center">
                            <h1 class="p-3 text-info"><i class="fa fa-2x fa-user-graduate"></i></h1>
                        </div>
                        <div class="card-footer text-center">{{$user->students()->count()}} Students</div>
                    </a>
                </div>
                <div class="col-sm-4 py-3">
                    <a href="/resources/mine" class="card">
                        <div class="card-body text-center">
                            <h1 class="p-3 text-success"><i class="fa fa-2x fa-folder"></i></h1>
                        </div>
                        <div class="card-footer text-center">
                            {{$resources}} Resources,
                            {{$user->resources()->count()}} mine
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 py-3">
                    <a href="/gradebook" class="card">
                        <div class="card-body text-center">
                            <h1 class="p-3 text-primary"><i class="fas fa-2x fa-sort-numeric-down"></i></h1>
                        </div>
                        <div class="card-footer text-center">Evaluation gradebook card</div>
                    </a>
                </div>
            </div>
        </div>
    -->
    </div>
</div>
</div>
@endsection
