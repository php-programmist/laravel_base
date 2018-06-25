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

    <script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
    {{--<script src="{{ asset('js/bootstrap.min.js') }}"></script>--}}

    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>

    {{--<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>--}}
    <script src="{{ asset('bootstrap/js/bootstrap-4-navbar.js') }}"></script>
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}


<!-- Latest compiled and minified JavaScript -->
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>--}}
<!-- Styles -->
    {{--<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap-4-hover-navbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

</head>
<body>

@section('navbar')

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top btco-hover-menu">
        <div class="container-fluid">
            {{--<a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>--}}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown {!! classActivePath('admin.users') !!}">
                        <a class="dropdown-toggle nav-link"
                           data-toggle="dropdown"
                           href="{{ route('admin.users.index')}}">
                            {{__('system.users')}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="nav-item {!! classActivePath('admin.users') !!}">
                                <a class="dropdown-item"
                                   href="{{ route('admin.users.index')}}">
                                    {{__('system.users_list')}}
                                </a>
                            </li>
                            <li class="nav-item {!! classActivePath('admin.groups.index') !!}"><a class="dropdown-item"
                                                                                                  href="{{ route('admin.groups.index')}}">{{__('system.groups')}}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown {!! classActivePath('admin.articles') !!}">
                        <a class="dropdown-toggle nav-link"
                           data-toggle="dropdown"
                           href="{{ route('admin.articles.index')}}">
                            {{__('system.articles')}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="nav-item {!! classActivePath('admin.articles.index') !!}">
                                <a class="dropdown-item"
                                   href="{{ route('admin.articles.index')}}">
                                    {{__('system.articles_list')}}
                                </a>
                            </li>
                            <li class="nav-item {!! classActivePath('admin.categories.index') !!}"><a
                                        class="dropdown-item"
                                        href="{{ route('admin.categories.index')}}">{{__('system.categories_list')}}</a>
                            </li>
                            <li class="nav-item {!! classActivePath('admin.comments.index') !!}"><a
                                        class="dropdown-item"
                                        href="{{ route('admin.comments.index')}}">{{__('system.comments_list')}}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {!! classActivePath('admin.menus.index') !!}">
                        <a class="nav-link" target="_blank"
                           href="{{ route('admin.menus.index')}}">{{__('system.menus')}}</a>
                    </li>

                </ul>
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" target="_blank" href="{{ route('home')}}">{{__('system.home')}}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <li class="nav-item">
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
<div id="toolbar" class="container-fluid">

    <div class="btn-toolbar" role="toolbar">
        @yield('toolbar')
    </div>


</div>

<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(Session::has('error'))
                <p class="alert alert-danger">{{ Session::get('error') }}</p>
            @endif

            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    <hr>
    <footer>
        <p>&copy; {{ date("Y") }} Company, Inc.</p>
    </footer>
</div>


<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>