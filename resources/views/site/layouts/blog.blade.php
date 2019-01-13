<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title OR 'Untitled' }}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('bootstrap/css/bootstrap-4-navbar.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('bootstrap/css/bootstrap-4-hover-navbar.css') }}" rel="stylesheet">
{{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}

<!-- Custom styles for this template -->
    {{--<link href="{{ asset('css/blog-home.css') }}" rel="stylesheet">--}}
    
    <link href="{{ asset('css/site.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body>

<!-- Navigation -->
@section('navigation')
    {!! $navigation OR '' !!}
@endsection
@yield('navigation')

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8 mt-2" id="app">
            @include('flash-message')

            @yield('content')


        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

            <!-- Search Widget -->
            <div class="card my-4">
                <h5 class="card-header">Search</h5>
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                  <button class="btn btn-secondary" type="button">Go!</button>
                </span>
                    </div>
                </div>
            </div>

            <!-- Categories Widget -->
            <div class="card my-4">
                <h5 class="card-header">{{ __('system.categories_list') }}</h5>
                <div class="card-body">
                    <div class="row">
                        @if(!empty($categories))
                            <div class="col-lg-6">
                                <ul class="list-unstyled mb-0">
                                    @foreach($categories as $k => $category)
                                        <li>
                                            <a href="{{ route('articlesCat',$category->id.'-'.$category->alias) }}">{{ $category->title }}</a>
                                        </li>
                                        @if(round(count($categories)/2)==$k+1)
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-unstyled mb-0">
                                    @endif
                                    @endforeach
                                </ul>
                            </div>

                        @endif
                    </div>
                </div>
            </div>

            <!-- Side Widget -->
            <div class="card my-4">
                <h5 class="card-header">Side Widget</h5>
                <div class="card-body">
                    You can put anything you want inside of these side widgets. They are easy to use, and feature the
                    new Bootstrap 4 card containers!
                </div>
            </div>

        </div>

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">&copy; {{ date("Y") }} {{ config('app.name', 'Laravel') }}</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="{{ asset('jquery/jquery.min.js') }}"></script>

<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap-4-navbar.js') }}"></script>
@yield('scripts')
</body>

</html>
