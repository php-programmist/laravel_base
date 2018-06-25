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
    <div class="form-group row">
        {!! Form::label('title', __('system.title'),['class'=>'col-sm-2 col-form-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('title',NULL,['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group row">
        {!! Form::label('alias', __('system.alias'),['class'=>'col-sm-2 col-form-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('alias',NULL,['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group row">
        {!! Form::label('state', __('system.state'),['class'=>'col-sm-2 col-form-label']) !!}
        <div class="col-sm-10">
            {!! Form::select('state', ['1' => __('system.published'), '0' => __('system.unpublished')]) !!}
        </div>
    </div>

    @if($categories)
        <div class="form-group row">
            {!! Form::label('parent_id', __('system.parent_category'),['class'=>'col-sm-2 col-form-label']) !!}
            <div class="col-sm-10">
                {!! Form::select('parent_id', $categories) !!}
            </div>
        </div>
    @endif
    {!! Form::hidden('task','',['id'=>'task']) !!}
    {!! Form::close() !!}



@endsection