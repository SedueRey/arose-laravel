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
                  <li class="breadcrumb-item"><a href="/students">My students</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit student</li>
                </ol>
            </nav>
            <form autocomplete="off" class="form" action="{{route('updateStudent', ['uuid' => $student->id] )}}" method="post" id="registrationForm">
                <h2>Edit student</h2>
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
                <input type="hidden" name="id" vale="{{$student->id}}" />
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="surname">
                            <h4>Family Name*</h4>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            name="surname"
                            id="surname"
                            value="{{old('surname', $student->surname)}}"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label for="name">
                            <h4>Given Name*</h4>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            id="name"
                            value="{{old('name', $student->name)}}"
                            required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="age">
                            <h4>Age</h4>
                        </label>
                        <input
                            type="number"
                            class="form-control"
                            name="age"
                            id="age"
                            value="{{old('age', $student->age)}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="class">
                            <h4>Class</h4>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            name="class"
                            id="class"
                            value="{{old('class', $student->class)}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="group">
                            <h4>Group</h4>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            name="group"
                            id="group"
                            value="{{old('group', $student->group)}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="level">
                            <h4>Level</h4>
                        </label>
                        <fieldset id="level">
                            <input type="radio" value="Unknown" name="level" @if(old('level', $student->level) == 'Unknown') checked @endif> Unknown &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="A1" name="level" @if(old('level', $student->level) == 'A1') checked @endif> A1 &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="A2" name="level" @if(old('level', $student->level) == 'A2') checked @endif> A2 &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="B1" name="level" @if(old('level', $student->level) == 'B1') checked @endif> B1 &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="B2" name="level" @if(old('level', $student->level) == 'B2') checked @endif> B2 &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="C1" name="level" @if(old('level', $student->level) == 'C1') checked @endif> C1 &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="C2" name="level" @if(old('level', $student->level) == 'C2') checked @endif> C2 &nbsp;&nbsp;&nbsp;
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
