@extends('layouts.admin')

@section('sidebar')
    <a href="{{ route('admin.articles') }}">
        <button class="btn-danger">{{__('system.close')}}</button>
    </a>
    <br>
    <button class="btn-success" onclick="getElementById('task').value='apply';getElementById('adminForm').submit()">
        {{__('system.save')}}
    </button>
    <br>
    <button class="btn-success" onclick="getElementById('task').value='save';getElementById('adminForm').submit()">
        {{__('system.save_and_close')}}
    </button>
@endsection;

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

        <form id="adminForm" method="post" action="{{ route('admin.article_save') }}">

            @csrf
            <input type="hidden" name="id" value="{{ $article->id }}">
            <div class="form-group">
                <label for="name">{{__('system.title')}}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name')?:$article->name }}">
            </div>
            <div class="form-group">
                <label for="alias">{{__('system.alias')}}</label>
                <input type="text" class="form-control" id="alias" name="alias"
                       value="{{ old('alias')?:$article->alias }}">
            </div>
            <div class="form-group">
                <label for="image">{{__('system.image')}}</label>
                <input type="text" class="form-control" id="image" value="{{ old('image')?:$article->image }}"
                       name="image">
            </div>
            <div class="form-group">
                <label for="intro_text">{{__('article.short_desc')}}</label>
                <textarea class="form-control" id="intro_text" name="intro_text"
                          rows="2">{{ old('intro_text')?:$article->intro_text }}</textarea>
            </div>
            <div class="form-group">
                <label for="full_text">{{__('article.full_desc')}}</label>
                <textarea class="form-control" id="full_text" name="full_text"
                          rows="5">{{ old('full_text')?:$article->full_text }}</textarea>
            </div>
            <div class="form-group">
                <label for="state">{{__('system.state')}}</label>
                <input type="text" class="form-control" id="state" value="{{ old('state')?:$article->state }}"
                       name="state">
            </div>

            <input type="hidden" name="id" id="id" value="{{ $article->id }}">
            <input type="hidden" name="task" id="task" value="">
        </form>

    </div>
@endsection