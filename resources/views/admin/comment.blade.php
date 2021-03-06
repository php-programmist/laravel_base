@extends('layouts.admin')

@section('toolbar')
    <button type="button" class="btn btn-success m-2" onclick="submit_button('apply')">
        {{__('system.save')}}
    </button>

    <button type="button" class="btn btn-success m-2" onclick="submit_button('save')">
        {{__('system.save_and_close')}}
    </button>

    <a href="{{ route('admin.users.index') }}">
        <button type="button" class="btn m-2 btn-danger">{{__('system.close')}}</button>
    </a>
@endsection

@section('content')

    @if($user->id)
        {!! Form::model($user,[
            'id'=>'adminForm',
            'class'=>'form-horizontal',
            'route' => [
                'admin.users.update',
                'user'=>$user->id
            ],
            'method'=>'put',
        ]) !!}
    @else
        {!! Form::model($user,[
            'id'=>'adminForm',
            'class'=>'form-horizontal',
            'route' => [
                'admin.users.store',
            ],
            'method'=>'post',
        ]) !!}
    @endif
    <div class="form-group row">
        {!! Form::label('name', __('system.name'),['class'=>'col-sm-2 col-form-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('name',NULL,['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group row">
        {!! Form::label('username', __('system.username'),['class'=>'col-sm-2 col-form-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('username',NULL,['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group row">
        {!! Form::label('email', __('system.email'),['class'=>'col-sm-2 col-form-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('email',NULL,['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group row">
        {!! Form::label('password', __('system.password'),['class'=>'col-sm-2 col-form-label']) !!}
        <div class="col-sm-10">
            {!! Form::password('password',['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group row">
        {!! Form::label('password_confirm', __('system.password_confirm'),['class'=>'col-sm-2 col-form-label']) !!}
        <div class="col-sm-10">
            {!! Form::password('password_confirm',['class' => 'form-control']) !!}
        </div>
    </div>
    @if($groups)
        <div class="form-group row">
            {!! Form::label('groups', __('system.groups'),['class'=>'col-sm-2 col-form-label']) !!}
            <div class="col-sm-10">
                <div class="form-check">
                    @foreach($groups as $group)

                        {!! Form::checkbox('groups[]', $group->id, $user->hasRole($group->name),['id'=>'group'.$group->id,'class'=>'form-check-input']); !!}
                        {!! Form::label('group'.$group->id, $group->name) !!}
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    {!! Form::hidden('task','',['id'=>'task']) !!}
    {!! Form::close() !!}



@endsection