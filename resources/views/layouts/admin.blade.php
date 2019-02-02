<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ $title }}</title>
	
	<script src="{{ asset('jquery/jquery.min.js') }}"></script>
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
	
	<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
	
	<script src="{{ asset('bootstrap/js/bootstrap-4-navbar.js') }}"></script>

	<link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('bootstrap/css/bootstrap-4-hover-navbar.css') }}" rel="stylesheet">
	<link rel="stylesheet"
		  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
	<link href="{{ asset('css/admin.css') }}" rel="stylesheet">

</head>
<body>

@section('navbar')
	{!! $navigation OR '' !!}
@show

@section('header')
		<div class="container">
			<h1>{{ $title }}</h1>
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
			
			@include('flash-message')
			
			@yield('content')
		</div>
	</div>
	
	<hr>
	<footer>
		<p>&copy; {{ date("Y") }} {{ config('app.name', 'Laravel') }}</p>
	</footer>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>