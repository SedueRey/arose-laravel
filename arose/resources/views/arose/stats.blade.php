@extends('layouts.app')

@section('content')
<div class="container">
    <div class="px-0 py-0 pt-md-5 pb-md-4 mx-auto">
        <h1 class="display-5">Admin stats</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Registered Users</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Added Students</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Added Rubrics</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="contact2-tab" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">Resources</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Registered users</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($registeredUsers as $data)
                            <tr>
                                <td><?php echo $data->created; ?></td>
                                <td><?php echo $data->c; ?></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Added Students</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($addedStudents as $data)
                            <tr>
                                <td><?php echo $data->created; ?></td>
                                <td><?php echo $data->c; ?></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Added Rubrics</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($addedRubrics as $data)
                            <tr>
                                <td><?php echo $data->created; ?></td>
                                <td><?php echo $data->c; ?></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact2-tab">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Resources</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($resources as $data)
                            <tr>
                                <td><?php echo $data->created; ?></td>
                                <td><?php echo $data->c; ?></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
