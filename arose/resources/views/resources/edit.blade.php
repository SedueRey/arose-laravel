@extends('layouts.app')

@section('content')

@php
$user = \Auth::user();
@endphp
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-sm-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/">Arose project</a></li>
                  <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="/resources/mine">My resources</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit resource properties</li>
                </ol>
            </nav>
            <form autocomplete="off" class="form" action="{{route('updateResource', ['id' => $resource->id])}}" method="post" id="registrationForm">
                <h2>Edit resource properties</h2>
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
                <input type="hidden" name="id" vale="{{$resource->id}}" />
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="name">
                            <h4>Name*</h4>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            id="name"
                            value="{{old('name', $resource->filename)}}"
                            required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <h5>File</h5>
                        <div class="alert alert-warning" role="alert">
                            You can't edit uploaded file, only its properties.
                        </div>
                        <a href="{{$resource->filepath}}" target="_blank">
                            View your uploaded file
                        </a>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="description">
                            <h4>Description</h4>
                        </label>
                        <textarea class="form-control" name="description" rows="4"
                        id="description">{{ old('description', $resource->desc) }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="level">
                            <h4>Level</h4>
                        </label>
                        <fieldset id="level">
                            <input type="radio" value="A1" name="level" @if(old('level', $resource->level) == 'A1') checked @endif> A1 &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="A2" name="level" @if(old('level', $resource->level) == 'A2') checked @endif> A2 &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="B1" name="level" @if(old('level', $resource->level) == 'B1') checked @endif> B1 &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="B2" name="level" @if(old('level', $resource->level) == 'B2') checked @endif> B2 &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="C1" name="level" @if(old('level', $resource->level) == 'C1') checked @endif> C1 &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="C2" name="level" @if(old('level', $resource->level) == 'C2') checked @endif> C2 &nbsp;&nbsp;&nbsp;
                        </fieldset>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="format">
                            <h4>Format</h4>
                        </label>
                        <fieldset id="format">
                            <input type="radio" value="Text" name="format" @if(old('format', $resource->format) == 'Text') checked @endif> Text &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="Audio" name="format" @if(old('format', $resource->format) == 'Audio') checked @endif> Audio &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="Video" name="format" @if(old('format', $resource->format) == 'Video') checked @endif> Video &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="Multimedia" name="format" @if(old('format', $resource->format) == 'Multimedia') checked @endif> Multimedia  &nbsp;&nbsp;&nbsp;
                        </fieldset>
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
