@if($menu)
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top btco-hover-menu">
		<div class="container-fluid">
			<a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
					aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav">
					
					@include('site.customMenuItems',['items'=>$menu->roots(),'isChild'=>false])
				
				</ul>
				
				@include('layouts.authmenu')
			
			</div>
		</div>
	</nav>
@endif