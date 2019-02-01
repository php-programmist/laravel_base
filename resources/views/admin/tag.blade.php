@extends('layouts.admin')

@section('toolbar')
	
	@include('layouts.editortoolbar',['view' => 'tags'])

@endsection

@section('content')
	@if($tag->id)
		<div class="card-body">
			{!! Form::model($tag,[
				'id'=>'adminForm',
				'class'=>'form-horizontal',
				'route' => [
					'admin.tags.update',
					'tag'=>$tag->id,

				],
				'method'=>'put',
				'files'=>true,
			]) !!}
			@else
				{!! Form::model($tag,[
					'id'=>'adminForm',
					'class'=>'form-horizontal',
					'route' => [
						'admin.tags.store',
					],
					'method'=>'post',
					'files'=>true,
				]) !!}
			@endif
			
			{{ Form::bsText('title',null,__('system.title')) }}
			{{ Form::bsText('alias') }}
			{!! Form::hidden('task','',['id'=>'task']) !!}
			{!! Form::close() !!}
		</div>
@endsection