@extends('layouts.admin')

@section('sidebar')
    <a href="{{ route('admin.articles.index') }}">
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

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif


        @if($article->id)
            {!! Form::model($article,[
                'id'=>'adminForm',
                'route' => [
                    'admin.articles.update',
                    'article'=>$article->id,
                    'files'=>true,
                ],
                'method'=>'put',
            ]) !!}
        @else
            {!! Form::model($article,[
                'id'=>'adminForm',
                'route' => [
                    'admin.articles.store',
                ],
                'method'=>'post',
                'files'=>true,
            ]) !!}
        @endif
        <div class="form-group">
            {!! Form::label('name', __('system.title')) !!}
            {!! Form::text('name',NULL,['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('alias', __('system.alias')) !!}
            {!! Form::text('alias',NULL,['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('image', __('system.image')) !!}
            {!! Form::file('image',NULL,['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('intro_text', __('article.short_desc')) !!}
            {!! Form::textarea('intro_text',NULL,['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('full_text', __('article.full_desc')) !!}
            {!! Form::textarea('full_text',NULL,['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('state', __('system.state')) !!}
            {!! Form::select('state', ['1' => __('system.published'), '0' => __('system.unpublished')],'1') !!}
        </div>
        {!! Form::hidden('task','',['id'=>'task']) !!}
        {!! Form::close() !!}

    </div>

@endsection