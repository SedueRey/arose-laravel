@extends('layouts.app')

@section('content')
<div class="container">
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto">
      <h1>What is AROSE platform?</h1>
      <p class="lead">
        AROSE is a project founded by Eramus+ to promote the assessment of English oral skills in secondary students. Here you can register and access to the digital platform developed in this project.
      </p>
    </div>
    <section class="row px-3 mt-4">
        <article class="col-md-12">
            <h1>Why is AROSE useful?</h1>
            <p>This digital tool will be useful to assess oral skills in A2 and B2 levels in English. You can use all the AROSE resources and you will be able to share the new ones you can create.</p>
        </article>
    </section>
    <section class="row p-3 mt-4">
        <article class="col-md-12">
            <h1 class="pb-4">What tools are there in AROSE</h1>
            <div class="row">
                <div class="col-md-4">
                    <img src="/img/browsing.svg" style="max-width: 100%; display:block; margin: 0 auto" alt="Tutorial" role="presentation" />
                </div>
                <div class="col-md-8">
                    <ol>
                        <li>A digital repository of public <strong class="text-primary">Resources</strong> to assess English oral skills. Feel free to add your own.</li>
                        <li>A <strong class="text-primary">Dashboard</strong> where you can watch a brief summary of your state in the platform.</li>
                        <li>A tool to register and manage your <strong class="text-primary">Students</strong></li>
                        <li>A tool to create and manage <strong class="text-primary">Rubrics</strong> for assessment</li>
                        <li>A <strong class="text-primary">Gradebook</strong> to manage the marks</li>
                        <li>A <strong class="text-primary">Forum</strong> and a <strong class="text-primary">Chat</strong> to connect with other secondary school teachers</li>
                    </ol>
                    <p class="ml-3">
                    <a class="btn btn-primary mr-2" href="/register">Register here</a> and begin to use AROSE
                    </p>
                </div>
            </div>
        </article>
    </section>
</div>
@endsection
