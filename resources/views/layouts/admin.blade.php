<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <!-- Scripts -->
{{--<script src="{{ asset('js/app.js') }}" defer></script>--}}
<!-- Latest compiled and minified CSS -->
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    {{--<script src="{{ asset('jquery/jquery-1.11.0.min') }}"></script>--}}
    <script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
    {{--<script src="{{ asset('js/bootstrap.min.js') }}"></script>--}}

    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


    <!-- Latest compiled and minified JavaScript -->
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>--}}
    <!-- Styles -->
    {{--<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet">--}}

</head>
<body>

@section('navbar')

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">{{ config('app.name', 'Laravel') }}</a>
            </div>


            <div class="collapse navbar-collapse" id="bs-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    <li class="dropdown {!! classActivePath('admin.users') !!}">
                        <a class="dropdown-toggle"
                           data-toggle="dropdown"
                           href="{{ route('admin.users.index')}}">
                            {{__('system.users')}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="{!! classActivePath('admin.users') !!}"><a
                                        href="{{ route('admin.users.index')}}">
                                    {{__('system.users_list')}}
                                </a>
                            </li>
                            <li><a href="#">Группы</a></li>
                        </ul>
                    </li>
                    <li class="dropdown {!! classActivePath('admin.articles') !!}">
                        <a class="dropdown-toggle"
                           data-toggle="dropdown"
                           href="{{ route('admin.articles.index')}}">
                            {{__('system.articles')}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="{!! classActivePath('admin.articles') !!}"><a
                                        href="{{ route('admin.articles.index')}}">
                                    {{__('system.articles_list')}}
                                </a>
                            </li>
                            <li><a href="#">Категории</a></li>
                        </ul>
                    </li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a target="_blank" href="{{ route('home')}}">{{__('system.home')}}</a></li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu{{-- dropdown-menu-right--}}" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('system.Logout') }}
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>


@show

@section('header')
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
            <h1>{{ $title }}</h1>
        </div>
    </div>
@show

<div class="container">
    <!-- Example row of columns -->
    <div class="row">

        <div class="col-md-3">
            <div class="sidebar-module">
                @section('sidebar')

                @show
            </div>
        </div>

        @yield('content')
    </div>

    <hr>
    <footer>
        <p>&copy; {{ date("Y") }} Company, Inc.</p>
    </footer>
</div>


<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>