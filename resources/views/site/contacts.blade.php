@extends('site.layouts.blog')

{{--@section('scripts')
	<script src="{{ asset('js/comments.js') }}"></script>
@endsection

@section('styles')
	<link href="{{ asset('css/contacts.css') }}" rel="stylesheet">
@endsection--}}

@section('content')
	<h1 class="my-4">{{ $title }}</h1>
	
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
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="media-container-column col-lg-12">
				
				{!! Form::open(['url' => route('contacts')]) !!}
				
				<div class="row row-sm-offset">
					<div class="col-md-6 multi-horizontal" data-for="name">
						<div class="form-group">
							<label class="form-control-label mbr-fonts-style display-7"
								   for="name">{{ __('system.name') }}</label>
							{!! Form::text('name',NULL,['class'=>'form-control','required'=>'']); !!}
						
						</div>
					</div>
					<div class="col-md-6 multi-horizontal" data-for="email">
						<div class="form-group">
							<label class="form-control-label mbr-fonts-style display-7"
								   for="email">{{ __('system.email') }}</label>
							{!! Form::email('email',NULL,['class'=>'form-control','required'=>'']); !!}
						</div>
					</div>
				</div>
				<div class="form-group" data-for="message">
					<label class="form-control-label mbr-fonts-style display-7"
						   for="text">{{ __('system.message') }}</label>
					{!! Form::textarea('text',NULL,['class'=>'form-control','required'=>'']); !!}
				</div>
				
				<span class="input-group-btn">
                            <button href="" type="submit"
									class="btn btn-primary btn-form display-4">{{ __('system.post_comment') }}</button>
                        </span>
				{!! Form::close() !!}
			</div>
		</div>
	</div>


@endsection
