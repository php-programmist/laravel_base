@extends('layouts.admin')

@section('toolbar')
    @include('layouts.editortoolbar',['view' => 'users'])
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
    {{ Form::bsText('name') }}
    {{ Form::bsText('username') }}
    {{ Form::bsEmail('email') }}

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