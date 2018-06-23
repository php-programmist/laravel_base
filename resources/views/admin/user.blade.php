@extends('layouts.admin')

@section('sidebar')
    <a href="{{ route('admin.users.index') }}">
        <button class="btn-danger">{{__('system.close')}}</button>
    </a>
    <br>
    <button class="btn-success" onclick="submit_button('apply')">
        {{__('system.save')}}
    </button>
    <br>
    <button class="btn-success" onclick="submit_button('save')">
        {{__('system.save_and_close')}}
    </button>
@endsection

@section('content')

    <div class="col-md-9">

        <div class="">
            <h2>{{ $title }}</h2>
        </div>

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
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
        <div class="form-group">
            {!! Form::label('name', __('system.name'),['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-8">
                {!! Form::text('name',NULL,['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('username', __('system.username'),['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-8">
                {!! Form::text('username',NULL,['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('email', __('system.email'),['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-8">
                {!! Form::text('email',NULL,['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('password', __('system.password'),['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-8">
                {!! Form::password('password',['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('password_confirm', __('system.password_confirm'),['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-8">
                {!! Form::password('password_confirm',['class' => 'form-control']) !!}
            </div>
        </div>
        @if($groups)
            <div class="form-group">
                {!! Form::label('groups', __('system.groups'),['class'=>'col-xs-2 control-label']) !!}
                <div class="col-xs-8">
                    @foreach($groups as $group)

                        {!! Form::checkbox('groups[]', $group->id, $user->hasRole($group->name),['id'=>'group'.$group->id]); !!}
                        {!! Form::label('group'.$group->id, $group->name) !!}
                        <br>
                    @endforeach
                </div>
            </div>
        @endif
        {!! Form::hidden('task','',['id'=>'task']) !!}
        {!! Form::close() !!}

    </div>

@endsection