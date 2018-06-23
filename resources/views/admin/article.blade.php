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

        @if(Session::has('error'))
            <p class="alert alert-danger">{{ Session::get('error') }}</p>
        @endif

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if($article->image AND file_exists(public_path('images').DIRECTORY_SEPARATOR.$article->image))
            <div class="mb-4">
                {{ Html::image('images/'.$article->image,$article->name ) }}
            </div>
        @endif
        @if($article->id)
            {!! Form::model($article,[
                'id'=>'adminForm',
                'class'=>'form-horizontal',
                'route' => [
                    'admin.articles.update',
                    'article'=>$article->id,

                ],
                'method'=>'put',
                'files'=>true,
            ]) !!}
        @else
            {!! Form::model($article,[
                'id'=>'adminForm',
                'class'=>'form-horizontal',
                'route' => [
                    'admin.articles.store',
                ],
                'method'=>'post',
                'files'=>true,
            ]) !!}
        @endif
        <div class="form-group">
            {!! Form::label('name', __('system.title'),['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-8">
                {!! Form::text('name',NULL,['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('alias', __('system.alias'),['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-8">
                {!! Form::text('alias',NULL,['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('image', __('system.image'),['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-8">
                {!! Form::file('image',['class' => 'filestyle']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('intro_text', __('article.short_desc'),['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-8">
                {!! Form::textarea('intro_text',NULL,['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('full_text', __('article.full_desc'),['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-8">
                {!! Form::textarea('full_text',NULL,['class' => 'form-control','id'=>'editor']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('state', __('system.state'),['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-8">
                {!! Form::select('state', ['1' => __('system.published'), '0' => __('system.unpublished')],'1') !!}
            </div>
        </div>
        {!! Form::hidden('task','',['id'=>'task']) !!}
        {!! Form::close() !!}

    </div>
    <script src="{{ asset('bootstrap/js/bootstrap-filestyle.js') }}"></script>
    <script>
	    CKEDITOR.replace('editor', {
		    language: '{{app()->getLocale()}}'

	    });

	    $('.filestyle').filestyle({
		    badge: true,
		    btnClass: 'btn-primary',
		    placeholder: '{{__('system.image_not_chosed')}}',
		    text: ' {{__('system.choose_file')}}'
	    });
    </script>
@endsection