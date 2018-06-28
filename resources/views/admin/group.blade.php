@extends('layouts.admin')

@section('toolbar')
	@include('layouts.editortoolbar',['view' => 'groups'])
@endsection

@section('content')
	
	@if($group->id)
		{!! Form::model($group,[
			'id'=>'adminForm',
			'class'=>'form-horizontal',
			'route' => [
				'admin.groups.update',
				'group'=>$group->id
			],
			'method'=>'put',
		]) !!}
	@else
		{!! Form::model($group,[
			'id'=>'adminForm',
			'class'=>'form-horizontal',
			'route' => [
				'admin.groups.store',
			],
			'method'=>'post',
		]) !!}
	@endif
	{{ Form::bsText('name') }}
	@if(!empty($permissions))
		<div class="form-group row">
			{!! Form::label('permissions', __('system.permissions'),['class'=>'col-sm-2 col-form-label']) !!}
			<div class="col-sm-10">
				<div class="row">
					@foreach($permissions as $key=> $perm)
						@if($key%4==1 OR $key==0)
							<div class="col-lg-3 mb-3">
								@endif
								{!! Form::checkbox('permissions[]', $perm->id, in_array($perm->id,$group_perms),['id'=>'permission'.$perm->id,'class'=>'form-check-input']); !!}
								{!! Form::label('permission'.$perm->id, perm_translate($perm->name)) !!}
								<br>
								@if($key%4==0)
							</div>
						@endif
					@endforeach
				</div>
			</div>
		</div>
	@endif
	
	{!! Form::hidden('task','',['id'=>'task']) !!}
	{!! Form::close() !!}



@endsection