<nav class="navbar navbar-expand-lg navbar-dark bg-primary navbar-laravel">
    <div class="container-fluid">
        @guest
        <a class="navbar-brand" href="{{ url('/') }}">
            Arose Project Webtool
        </a>
        @else
        <a class="navbar-brand" href="{{ url('/home') }}">
            Arose Project Webtool
        </a>
        @endguest
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="/resources">Resources</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/resources/public">Open Educational Resources</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/home">Dashboard</a>
                    </li>
                    <li class="nav-item">

                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarResources" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Resources <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarResources">
                            <a class="dropdown-item" href="/resources">Arose Resources</a>
                            <a class="dropdown-item" href="/resources/public">Open Educational Resources</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-nowrap" href="/students">My Students</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdownRubrics" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Rubrics <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownRubrics">
                            <a class="dropdown-item" href="/rubrics">
                                My Rubrics
                            </a>
                            <a class="dropdown-item" href="/aroserubrics">
                                Arose Rubrics
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdownGradebook" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Gradebook <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownGrade">
                            <a class="dropdown-item" href="/gradebook">
                                Grade students
                            </a>
                            <a class="dropdown-item" href="/gradebook/config">
                                Config my Gradebook
                            </a>
                            <a class="dropdown-item" href="/gradebook/stats">
                                Statistics
                            </a>
                            <a class="dropdown-item" href="/gradebook/summary">
                                Summary
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/chat">Chat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/forum">Forum</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name ?: 'Your menu' }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/profile">
                                Edit profile
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
