@extends('layouts.admin')

@section('toolbar')
    <button type="button" class="btn btn-success m-2" onclick="submit_button('apply')">
        {{__('system.save')}}
    </button>

    <button type="button" class="btn btn-success m-2" onclick="submit_button('save')">
        {{__('system.save_and_close')}}
    </button>

    <button type="button" class="btn btn-success m-2" onclick="submit_button('save2new')">
        {{__('system.save_and_new')}}
    </button>

    <a href="{{ route('admin.categories.index') }}">
        <button type="button" class="btn m-2 btn-danger">{{__('system.close')}}</button>
    </a>
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