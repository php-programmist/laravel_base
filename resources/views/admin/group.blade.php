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
    {!! Form::hidden('task','',['id'=>'task']) !!}
    {!! Form::close() !!}



@endsection