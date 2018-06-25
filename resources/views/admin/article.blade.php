@extends('layouts.admin')

@section('toolbar')

    @include('layouts.editortoolbar',['view' => 'articles'])

@endsection

@section('content')
    @if($article->id)
        @if($article->image AND file_exists(public_path('images').DIRECTORY_SEPARATOR.$article->image))
            <div class="card mb-4">
                {{ Html::image('images/'.$article->image,$article->name ) }}
            </div>
        @endif
        <div class="card-body">
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
            <div class="form-group row">
                {!! Form::label('name', __('system.title'),['class'=>'col-sm-2 col-form-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('name',NULL,['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                {!! Form::label('alias', __('system.alias'),['class'=>'col-sm-2 col-form-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('alias',NULL,['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('category_id', __('system.parent_category'),['class'=>'col-sm-2 col-form-label']) !!}
                <div class="col-sm-10">
                    {!! Form::select('category_id', $categories) !!}
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('image', __('system.image'),['class'=>'col-sm-2 col-form-label']) !!}
                <div class="col-sm-10">
                    {!! Form::file('image',['class' => 'filestyle']) !!}
                </div>
            </div>

            <div class="form-group row">
                {!! Form::label('intro_text', __('article.short_desc'),['class'=>'col-sm-2 col-form-label']) !!}
                <div class="col-sm-10">
                    {!! Form::textarea('intro_text',NULL,['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                {!! Form::label('full_text', __('article.full_desc'),['class'=>'col-sm-2 col-form-label']) !!}
                <div class="col-sm-10">
                    {!! Form::textarea('full_text',NULL,['class' => 'form-control','id'=>'editor']) !!}
                </div>
            </div>

            <div class="form-group row">
                {!! Form::label('state', __('system.state'),['class'=>'col-sm-2 col-form-label']) !!}
                <div class="col-sm-10">
                    {!! Form::select('state', ['1' => __('system.published'), '0' => __('system.unpublished')]) !!}
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