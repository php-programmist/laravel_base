@extends('layouts.admin')

@section('sidebar')
    <a href="{{ route('admin.article_new') }}">
        <button class="btn-success">{{__('system.add')}}</button>
    </a>
@endsection

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

        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        @if ($articles)
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Id</th>
                    <th>{{__('system.title')}}</th>
                    <th>{{__('system.username')}}</th>
                    <th>{{__('system.state')}}</th>
                    <th>{{__('system.created_at')}}</th>
                    <th>{{__('system.updated_at')}}</th>
                </tr>
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td><a href="{{ route('admin.article_update',$article->id) }}">{{ $article->name }}</a></td>
                        <td>{{ $article->user->username }}</td>
                        <td>{{ $article->state?__('system.published'):__('system.unpublished') }}</td>
                        <td>{{ $article->created_at }}</td>
                        <td>{{ $article->updated_at }}</td>
                    </tr>
                @endforeach
            </table>
            <div class="center">{{ $articles->links() }}</div>
        @endif

    </div>
@endsection