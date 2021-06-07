@extends('layouts.app')

@section('content')

@php
$user = \Auth::user();
@endphp
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-sm-10">
            <h1>{{$user->name}}</h1>
            <p>{{$user->email}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="text-center">
            <form class="form" action="{{route('profilephoto')}}" method="post" id="registrationForm" enctype="multipart/form-data">
                @csrf
                <label for="photo" style="cursor:pointer;">
                @if ($user->photo)
                <img src="{{ asset('/storage/avatar/'.Auth::user()->photo) }}" class="avatar img-circle img-thumbnail" alt="avatar">
                @else
                <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar">
                @endif
                    Upload a different photo...
                </label>
                <input type="file" style="display:none" id="photo" name="photo" >
                <button type="submit" class="btn btn-secondary">Upload</button>
            </form>
            </div>
        </div>
        <div class="col-sm-9">
            <form autocomplete="off" class="form" action="{{route('profileuser')}}" method="post" id="registrationForm">
                <h2>Edit profile data</h2>
                @csrf
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="name">
                            <h4>Complete name*</h4>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            id="name"
                            value="{{$user->name}}"
                            required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="school">
                            <h4>School</h4>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            name="school"
                            id="school"
                            value="{{$user->school}}"
                            >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="city">
                            <h4>City</h4>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            name="city"
                            id="city"
                            value="{{$user->city}}"
                            >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="country">
                            <h4>Country</h4>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            name="country"
                            id="country"
                            value="{{$user->country}}"
                            >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="country">
                            <h4>Bio</h4>
                        </label>
                        <textarea
                            type="text"
                            class="form-control"
                            name="biography"
                            id="biography"
                            rows="8"
                            >{{$user->biography}}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <br>
                        <button class="btn btn-secondary" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                        <button class="btn btn" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<!--/row-->
</div>
@endsection
