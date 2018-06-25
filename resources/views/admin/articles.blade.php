@extends('layouts.admin')

@section('toolbar')
    <a href="{{ route('admin.articles.create') }}">
        <button class="btn btn-success m-2">{{__('system.add')}}</button>
    </a>
@endsection

@section('content')

        @if ($articles)
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Id</th>
                        <th>{{__('system.title')}}</th>
                        <th>{{__('system.alias')}}</th>
                        <th>{{__('system.category')}}</th>
                        <th>{{__('system.username')}}</th>
                        <th>{{__('system.state')}}</th>
                        <th>{{__('system.created_at')}}</th>
                        <th>{{__('system.link')}}</th>
                        <th></th>
                    </tr>
                    @foreach($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td><a href="{{ route('admin.articles.edit',$article->id) }}">{{ $article->name }}</a></td>
                            <td>{{ $article->alias }}</td>
                            <td>{{ $article->category->title }}</td>
                            <td>{{ $article->user->username }}</td>
                            <td>
                                {{ $article->state?Html::image(asset('icons/tick.png'),__('system.published')) :Html::image(asset('icons/publish_x.png'),__('system.unpublished')) }}
                            </td>
                            <td>{{ $article->created_at->format('d.m.Y H:i') }}</td>
                            <td><a target="_blank"
                                   href="{{ route('articles',$article->id.'-'.$article->alias) }}">{{ __('system.preview') }}</a>
                            </td>
                            <td>
                                {!! Form::open([
                                    'url'=>route('admin.articles.destroy',['article'=>$article->id]),
                                    'class'=>'form-horizontal',
                                    'method'=>'DELETE'
                                ]) !!}
                                {!! Form::button(__('system.delete'),['class'=>'btn btn-xs btn-danger','type'=>'submit']) !!}

                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $articles->links() }}
        @endif


@endsection