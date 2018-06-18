@extends('layouts.admin')

@section('sidebar')
    <a href="{{ route('article_new') }}">
        <button class="btn-success">Добавить</button>
    </a>
@endsection;

@section('content')

    <div class="col-md-9">
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

        @if ($articles)
            <table class="table table-responsive">
                <tr>
                    <th>Id</th>
                    <th>Назание</th>
                    <th>Автор</th>
                    <th>Статус</th>
                    <th>Дата создания</th>
                </tr>
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td><a href="{{ route('article_update',$article->id) }}">{{ $article->name }}</a></td>
                        <td>{{ $article->user->username }}</td>
                        <td>{{ $article->state?"Опубликовано":"Не опубликовано" }}</td>
                        <td>{{ $article->created_at }}</td>
                    </tr>
                @endforeach
            </table>
        @endif

    </div>
@endsection