@extends('layouts.app')

@section('content')
<div class="container">
    <div class="px-0 py-0 pt-md-5 pb-md-4 mx-auto">
        <h1 class="display-5">Bulk students import finished</h1>
    </div>
    <div class="row text-center">
        <div class="col-md-4 text-muted p-3" id="bulk-step-one">Step 1. Download and upload template</div>
        <div class="col-md-4 text-muted p-3" id="bulk-step-two">Step 2. Check uploaded data</div>
        <div class="col-md-4 font-weight-bold text-secondary p-3" id="bulk-step-three">Step 3. Finished</div>
    </div>
    <hr class="hr" />
    <div class="row">
        <div class="col-md-12">
            <p>All students who had the correct data and have been selected by you have been imported.</p>
            <p>You can see them, and continue editing them, in the
                <a href="/students">list of your students</a>.
            </p>
        </div>
    </div>
</div>
@endsection
