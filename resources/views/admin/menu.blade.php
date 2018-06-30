@extends('layouts.admin')

@section('toolbar')
	@include('layouts.editortoolbar',['view' => 'menus'])
@endsection

@section('content')
	
	@if($menu->id)
		{!! Form::model($menu,[
			'id'=>'adminForm',
			'class'=>'form-horizontal',
			'route' => [
				'admin.menus.update',
				'menu'=>$menu->id
			],
			'method'=>'put',
		]) !!}
	@else
		{!! Form::model($menu,[
			'id'=>'adminForm',
			'class'=>'form-horizontal',
			'route' => [
				'admin.menus.store',
			],
			'method'=>'post',
		]) !!}
	@endif
	{{ Form::bsText('title') }}
	
	
	@if($menus)
		{{ Form::bsSelect('parent_id',$menus,NULL,__('system.parent_menu')) }}
	@endif
	{{ Form::bsSelect('element',$elements) }}
	
	<div id="hidden">
		<div class="custom">
			{{ Form::bsText('path') }}
		</div>
		
		<div class="article">
			{{ Form::bsSelect('article',$articles,$menu->path) }}
		</div>
		
		<div class="category">
			{{ Form::bsSelect('category',$categories,$menu->path) }}
		</div>
		<div class="contact"></div>
	</div>
	{!! Form::hidden('task','',['id'=>'task']) !!}
	{!! Form::close() !!}
	<script>
		function element_change() {
			var val = $("#element :selected").val();
			$('#hidden > div').slideUp();
			$('div.' + val).slideDown();
		}
		
		$(document).ready(function () {
			element_change();
			$('#element').change(element_change);
		});
	</script>


@endsection