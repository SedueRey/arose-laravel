@extends('layouts.app')

@section('content')
<div class="container">
    <div class="px-0 py-0 pt-md-5 pb-md-4 mx-auto">
        <h1 class="display-5">Bulk students import: Checking uploaded data</h1>
    </div>
    <div class="row text-center">
        <div class="col-md-4 text-muted p-3" id="bulk-step-one">Step 1. Download and upload template</div>
        <div class="col-md-4 font-weight-bold text-secondary p-3" id="bulk-step-two">Step 2. Check uploaded data</div>
        <div class="col-md-4 text-muted p-3" id="bulk-step-three">Step 3. Finished</div>
    </div>
    <hr class="hr" />
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-sm">
        <thead>
            <tr class="text-center">
                <th></th>
                <th>Family Name</th>
                <th>Given Name</th>
                <th>Age</th>
                <th>Class</th>
                <th>Level</th>
                <th>Group</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($studentRawList as $student)
            <tr
                class="table-{{$student->status}}"
            >
                <td class="text-center">
                    <input type="checkbox" name="" id="" aria-label=""
                        @if($student->status === 'light')
                        checked
                        @endif
                    />
                </td>
                <td>
                    <input class="form-control form-control-sm" type="text" name="" value="{{$student->surname}}" />
                </td>
                <td>
                    <input class="form-control form-control-sm" type="text" name="" value="{{$student->name}}" />
                </td>
                <td class="text-right">
                    <input style="width: 100%" class="form-control form-control-sm" type="number" step="1" name="" value="{{$student->age}}" />
                </td>
                <td class="text-center">
                    <input style="width: 100%" class="form-control form-control-sm" type="text" name="" value="{{$student->class}}" />
                </td>
                <td>{{$student->level}}</td>
                <td>
                    <input style="width: 100%" class="form-control form-control-sm" type="text" name="" value="{{$student->group}}" />
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    {{ json_encode($studentRawList, JSON_FORCE_OBJECT) }}
</div>
@endsection
