@extends('layouts.admin')

@section('toolbar')
	<a href="{{ route('admin.tags.create') }}">
		<button class="btn btn-success m-2">{{__('system.add')}}</button>
	</a>
@endsection

@section('content')
	
	@if ($tags)
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<tr>
					<th>Id</th>
					<th>{{__('system.title')}}</th>
					<th>{{__('system.alias')}}</th>
					<th>{{__('system.created_at')}}</th>
					<th></th>
				</tr>
				@foreach($tags as $tag)
					<tr>
						<td>{{ $tag->id }}</td>
						<td><a href="{{ route('admin.tags.edit',$tag->id) }}">{{ $tag->title }}</a></td>
						<td>{{ $tag->alias }}</td>
						<td>{{ $tag->created_at->format('d.m.Y H:i') }}</td>
						<td>
							{!! Form::open([
								'url'=>route('admin.tags.destroy',['tag'=>$tag->id]),
								'class'=>'form-horizontal',
								'method'=>'DELETE'
							]) !!}
							{!! Form::button(__('system.delete'),['class'=>'btn btn-xs btn-danger','type'=>'submit']) !!}
							
							{!! Form::close() !!}
						</td>
					</tr>
				@endforeach
			</table>
		</div>
		{{ $tags->links() }}
	@endif


@endsection