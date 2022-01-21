@extends('layouts.app')

@section('content')
<div class="container">
    <div class="px-0 py-0 pt-md-5 pb-md-4 mx-auto">
        <h1 class="display-5">Bulk students import</h1>
    </div>
    <div class="row text-center">
        <div class="col-md-4 font-weight-bold text-secondary p-3" id="bulk-step-one">Step 1. Download and upload template</div>
        <div class="col-md-4 text-muted p-3" id="bulk-step-two">Step 2. Check uploaded data</div>
        <div class="col-md-4 text-muted p-3" id="bulk-step-three">Step 3. Finished</div>
    </div>
    <hr class="hr" />
    <div class="row">
        <div class="col-md-12">
            <h4>Template</h4>
            <p>We have made a template for you to fill the data with your students and upload it again. It's not an Excel file but you can open it with Excel, OpenOffice or other software you may have.</p>
            <p>It's call a CSV file, so feel free to download it and upload your students all in a couple steps.</p>
            <p><a href="{{ asset('csv/students.csv') }}" class="btn btn-primary" download>Download CSV template</a></p>
        </div>
    </div>
    <hr class="hr" />
    <div class="row">
        <div class="col-md-12">
            <h4>Now you can upload it</h4>
            <form
                autocomplete="off"
                class="form"
                action="{{route('showListUploaded')}}"
                method="post"
                id="registrationForm"
                enctype="multipart/form-data"
            >
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
                <label for="studentsfile">
                    Choose your CSV file: <br>
                    <input id="studentsfile" name="studentsfile" type="file" accept=".csv" />
                </label><br>
                <button type="submit" class="btn btn-primary">Upload file!</button>
            </form>
        </div>
    </div>
</div>
@endsection
