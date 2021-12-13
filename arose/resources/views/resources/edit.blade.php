@extends('layouts.app')

@section('content')

@php
$user = \Auth::user();
@endphp
<script src="//code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
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
                            <input aria-labelledby="a1" type="radio" value="A1" name="level" @if(old('level', $resource->level) == 'A1') checked @endif> <span id="a1">A1 &nbsp;&nbsp;&nbsp;</span>
                            <input aria-labelledby="a2" type="radio" value="A2" name="level" @if(old('level', $resource->level) == 'A2') checked @endif> <span id="a2">A2 &nbsp;&nbsp;&nbsp;</span>
                            <input aria-labelledby="b1" type="radio" value="B1" name="level" @if(old('level', $resource->level) == 'B1') checked @endif> <span id="b1">B1 &nbsp;&nbsp;&nbsp;</span>
                            <input aria-labelledby="b2" type="radio" value="B2" name="level" @if(old('level', $resource->level) == 'B2') checked @endif> <span id="b2">B2 &nbsp;&nbsp;&nbsp;</span>
                            <input aria-labelledby="c1" type="radio" value="C1" name="level" @if(old('level', $resource->level) == 'C1') checked @endif> <span id="c1">C1 &nbsp;&nbsp;&nbsp;</span>
                            <input aria-labelledby="c2" type="radio" value="C2" name="level" @if(old('level', $resource->level) == 'C2') checked @endif> <span id="c2">C2 &nbsp;&nbsp;&nbsp;</span>
                        </fieldset>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="format">
                            <h4>Format</h4>
                        </label>
                        <fieldset id="format">
                            <input aria-labelledby="text" type="radio" value="Text" name="format" @if(old('format', $resource->format) == 'Text') checked @endif> <span id="text">Text &nbsp;&nbsp;&nbsp;</span>
                            <input aria-labelledby="audio" type="radio" value="Audio" name="format" @if(old('format', $resource->format) == 'Audio') checked @endif> <span id="audio">Audio &nbsp;&nbsp;&nbsp;</span>
                            <input aria-labelledby="video" type="radio" value="Video" name="format" @if(old('format', $resource->format) == 'Video') checked @endif> <span id="video">Video &nbsp;&nbsp;&nbsp;</span>
                            <input aria-labelledby="multimedia" type="radio" value="Multimedia" name="format" @if(old('format', $resource->format) == 'Multimedia') checked @endif> <span id="multimedia">Multimedia  &nbsp;&nbsp;&nbsp;</span>
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
                @if ($other->count() > 0)
                <div class="form-group">
                    <div class="col-xs-6">
                        <hr/>
                        <h4 id="related">Your resources, {{ $other->count() }} possible to bind</h4>
                        <div class="card card-body">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">
                                    <i class="fa fa-search"></i>
                                  </span>
                                </div>
                                <input class="form-control" id="search" type="search" aria-labelledby="related" value="" placeholder="search for your documents" />
                            </div>
                            <hr>
                            <div class="row">
                            @foreach($other as $item)
                            <div
                                class="form-check searching-items col-md-4"
                                data-filename="{{ $item->filename }}"
                                @if (in_array($item->id, $related))
                                data-checked="checked"
                                @endif
                            >
                            <label class="form-check-label" for="related['{{$item->id}}']">
                                <input
                                    @if (in_array($item->id, $related))
                                    checked
                                    @endif
                                    class="form-check-input"
                                    type="checkbox"
                                    name="related['{{$item->id}}']"
                                    id="related['{{$item->id}}']"
                                 /> {{ $item->filename }}</label>
                            </div>
                            @endforeach
                            </div>
                        </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <br>
                        <button class="btn btn-secondary" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                        <button class="btn btn" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
                    </div>
                </div>
                @endif
                <script>
                    $(document).ready(function(){
                        $('#search').on('keyup', function() {
                            const search = $('#search').val().toLowerCase();
                            $('.searching-items').hide();
                            $('.searching-items').each( function() {
                                if ( $(this).data('filename').toLowerCase().indexOf(search) > -1 ) {
                                    $(this).show();
                                }
                            });
                        })
                    })
                </script>
            </form>
        </div>
    </div>
<!--/row-->
</div>
@endsection
