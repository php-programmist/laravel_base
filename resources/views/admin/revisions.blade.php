@extends('layouts.admin')

@section('toolbar')
	<a href="{{ route('admin.articles.index') }}">
		<button type="button" class="btn m-2 btn-danger">{{__('system.close')}}</button>
	</a>
@endsection

@section('content')
	
	@if ($revisions)
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<tr>
					<th>Id</th>
					<th>{{__('system.created_at')}}</th>
					<th>{{__('system.username')}}</th>
					<th></th>
					<th></th>
				</tr>
				@foreach($revisions as $revision)
					<tr>
						<td>{{ $revision->id }}</td>
						<td>{{ $revision->created_at->format('d.m.Y H:i') }}
							@if($revision->is_active)
								<i class="fa fa-star" style="color:gold" aria-hidden="true"></i>
							@endif
						</td>
						<td>{{ $revision->user->username }}</td>
						<td>
							{!! Form::open([
								'url'=>route('admin.revision.restore',['revision_id'=>$revision->id]),
								'class'=>'form-horizontal',
								'method'=>'POST'
							]) !!}
							{!! Form::button(__('system.restore'),['class'=>'btn btn-xs btn-success','type'=>'submit']) !!}
							
							{!! Form::close() !!}
						</td>
						<td>
							{!! Form::open([
								'url'=>route('admin.revision.destroy',['revision_id'=>$revision->id]),
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
	@else
		<h3>{{__('system.no_revisions')}}</h3>
	@endif


@endsection