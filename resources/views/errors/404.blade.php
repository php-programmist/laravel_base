@extends('site.layouts.blog')

@section('content')
	<div id="content-index" class="content group">
		<img class="error-404-image group" src="{{ asset('/images/404.png') }}" title="Error 404" alt="404" />
		<div class="error-404-text group">
			<h2 class="center my-3">{{ __('system.page_not_found') }}</h2>
		
		</div>
	</div>
@endsection