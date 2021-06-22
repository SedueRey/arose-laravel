@extends('layouts.app')

@section('content')

@php
$user = \Auth::user();
@endphp
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-sm-12">
            <form autocomplete="off" class="form" action="{{route('updateStudent', ['uuid' => $student->id] )}}" method="post" id="registrationForm">
                <h2>Create student</h2>
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
                            value="{{old('name', $student->name)}}"
                            required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="name">
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
                        <label for="name">
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
                        <label for="name">
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
