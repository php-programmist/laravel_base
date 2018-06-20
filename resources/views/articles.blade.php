@extends('layouts.blog')

@section('content')
    <h1 class="my-4">Статьи

    </h1>

    @if ($articles)


        @foreach($articles as $article)

            <!-- Blog Post -->
            <article class="card mb-4">
                <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
                <div class="card-body">
                    <header>
                        <h2 class="card-title">
                            <a href="{{ route('articles',$article->id.'-'.$article->alias) }}">{{ $article->name }}</a>
                        </h2>
                    </header>

                    @if($article->intro_text)
                        <p class="card-text">
                            {{ $article->intro_text }}
                        </p>

                        <a href="{{ route('articles',$article->id.'-'.$article->alias) }}">
                            <button class="btn btn-primary">{{ __('article.read_more') }} &rarr;</button>
                        </a>
                    @else
                        <p class="card-text">
                            {{ $article->full_text }}
                        </p>
                    @endif


                </div>

                <footer class="card-footer text-muted">
                    <time datetime="{{ date("Y-m-d\TH:i",strtotime($article->created_at)) }}">
                        {{ date("d.m.Y H:i",strtotime($article->created_at)) }}
                    </time>
                    <div class="author">{{ __('article.author') }}: {{ $article->user->name }}</div>
                </footer>

            </article>
        @endforeach

    @endif
    <!-- Pagination -->
    <nav class="center">{{ $articles->links() }}</nav>


@endsection