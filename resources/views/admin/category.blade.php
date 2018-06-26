@extends('layouts.admin')

@section('toolbar')
    @include('layouts.editortoolbar',['view' => 'categories'])
@endsection

@section('content')

    @if($category->id)
        {!! Form::model($category,[
            'id'=>'adminForm',
            'class'=>'form-horizontal',
            'route' => [
                'admin.categories.update',
                'category'=>$category->id
            ],
            'method'=>'put',
        ]) !!}
    @else
        {!! Form::model($category,[
            'id'=>'adminForm',
            'class'=>'form-horizontal',
            'route' => [
                'admin.categories.store',
            ],
            'method'=>'post',
        ]) !!}
    @endif
    {{ Form::bsText('title') }}
    {{ Form::bsText('alias') }}
    {{ Form::bsSelect('state',['1' => __('system.published'), '0' => __('system.unpublished')]) }}

    @if($categories)
        {{ Form::bsSelect('parent_id',$categories,NULL,__('system.parent_category')) }}
    @endif
    {!! Form::hidden('task','',['id'=>'task']) !!}
    {!! Form::close() !!}



@endsection