@extends('layouts.blog')

@section('content')
    @if ($article)

        <!-- Blog Post -->
        <article class="card mb-4">
            @if($article->image AND file_exists(public_path('images').DIRECTORY_SEPARATOR.$article->image))
                {{ Html::image('images/'.$article->image,$article->name,['class'=> 'card-img-top'] ) }}
            @endif

            <div class="card-body">
                <header>
                    <h2 class="card-title">
                        {{ $article->name }}
                    </h2>
                </header>
                <p class="card-text">
                    @if($article->intro_text)
                        {!! $article->intro_text !!}
                    @endif
                    {!! $article->full_text  !!}

                </p>

            </div>

            <footer class="card-footer text-muted">
                <time datetime="{{ date("Y-m-d\TH:i",strtotime($article->created_at)) }}">
                    {{ date("d.m.Y H:i",strtotime($article->created_at)) }}
                </time>
                <div class="author">{{ __('article.author') }}: {{ $article->user->name }}</div>
                <a href="{{ url()->previous() }}">
                    <button class="btn btn-primary">&larr; {{ __('article.back') }} </button>
                </a>
            </footer>

        </article>

    @endif


@endsection
