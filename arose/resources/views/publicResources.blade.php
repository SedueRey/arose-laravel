@extends('layouts.app')

@section('content')
<div class="container">
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Open Educational Resources</h1>
        <p class="lead">
            Open educational resources (OER) are teaching, learning, and research materials intentionally
            created and licensed to be free for the end user to own, share, and in most cases, modify.
            The term "OER" describes publicly accessible materials and resources for any user to use, re-mix,
            improve, and redistribute under some licenses.
            These are designed to reduce accessibility barriers by implementing best practices in teaching
            and to be adapted for local unique contexts.
        </p>
      </div>
    <section class="row">
        <h4 class="col-lg-12">
           There are {{ count($publicResources) }} open resources.
           <hr />
        </h4>
    @foreach($publicResources as $data)
    <div class="col-lg-6">
    <article class="card card-arose">
        <div class="card-body">
            <div class="row p-3">
                <div class="col-12">
                    @if (str_starts_with($data[10], 'http'))
                    <h5>
                        <a target="_blank" href="{{$data[10]}}">
                            {{ $data[8] }}
                        </a>
                    </h5>
                    <p>{{ ucfirst($data[5])}} <br />By {{ ucfirst($data[9])}}</p>
                    @else
                    <h5>
                        <a target="_blank" href="{{$data[9]}}">
                            {{ $data[8] }}
                        </a>
                    </h5>
                    <p>{{ ucfirst($data[5])}}<br />By {{ ucfirst($data[10])}}</p>
                    @endif
                    <hr>
                    <p>
                        <span class="badge badge-secondary">{{$data[6]}}</span>
                        <span class="badge badge-secondary">{{$data[1]}}</span>
                    </p>
                    @if(!empty($data[11]))
                    <p class="mb-0 pb-0">Licensed by {{ $data[11] }}</p>
                    @endif
                </div>
            </div>
        </div>
    </article>
    </div>
    @endforeach
    <aside class="p-4 mt-8">
        <h1 class="display-6 pt-8">Public repositories</h1>
        <ul>
            <li>
                <h4><a href="https://www.oercommons.org/">OERCommons</a></h4>
                <p>OER Commons is a public digital library of open educational resources. Explore, create, and collaborate with educators around the world to improve curriculum.</p>
            </li>
            <li>
                <h4><a href="https://www.europeana.eu/es/about-us">Europeana</a></h4>
                <p>Digital access to European historical cultural material, organized in images, text, sound, video and 3D.</p>
            </li>
            <li>
                <h4><a href="http://www.merlot.org/merlot/materials.htm">MERLOT</a></h4>
            </li>
            <li>
                <h4><a href="https://www.ted.com/">TED talks</a></h4>
            </li>
            <li>
                <h4><a href="https://procomun.intef.es/">PROCOMÚN</a></h4>
                <p>It is a network of open educational resources created by INTEF.</p>
            </li>
            <li>

                <h4><a href="https://www.youtube.com/">Youtube</a></h4>
                <p>You have to search for content in the website with creative commons license, by typing: content,creativecommons</p>
            </li>
        </ul>
    </aside>
    </section>
</div>
@endsection
