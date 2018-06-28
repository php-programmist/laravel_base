@extends('site.layouts.blog')

@section('scripts')
	<script src="{{ asset('js/comments.js') }}"></script>
@endsection

@section('styles')
	<link href="{{ asset('css/comments.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if ($article)

        <!-- Blog Post -->
        <article class="card mb-4">
            @if($article->image AND file_exists(public_path('images/articles').DIRECTORY_SEPARATOR.$article->image))
                {{ Html::image('images/articles/'.$article->image,$article->name,['class'=> 'card-img-top'] ) }}
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
                <div class="category">{{ __('system.category') }}: <a
                            href="{{ route('articlesCat',$article->category->id.'-'.$article->category->alias) }}">{{ $article->category->title }}</a>
                </div>
                <a href="{{ url()->previous() }}">
                    <button class="btn btn-primary">&larr; {{ __('article.back') }} </button>
                </a>
            </footer>

        </article>

        <!-- START COMMENTS -->
        <div id="comments">
            <h3 id="comments-title">
                <span>{{ count($article->comments) }}</span> {{ Lang::choice('system.comments',count($article->comments)) }}
            </h3>
            <div class="wrap_result"></div>
            @if(count($article->comments))
                <ol class="commentlist group">
                    @include('site.comment',['items' => $comments_groups[0],'comments_groups'=>$comments_groups])

                </ol>
            @endif

            <div id="respond">
                <h3 id="reply-title">{{ __('system.leave_reply') }}
                    <small><a rel="nofollow" id="cancel-comment-reply-link" href="#respond"
                              style="display:none;">{{ __('system.cancel_reply') }}</a></small>
                </h3>
                <form action="{{ route('comment.store') }}" method="post" id="commentform">
                    @if(!\Auth::check())
                        <p class="comment-form-author">
                            <label for="name">{{ __('system.name') }}</label>
                            <input id="name" name="name" type="text" value="" size="30" aria-required="true"/>
                        </p>
                        <p class="comment-form-email">
                            <label for="email">{{ __('system.email') }}</label>
                            <input id="email" name="email" type="text" value="" size="30" aria-required="true"/>
                        </p>
                    @endif
                    <p class="comment-form-comment"><label for="text">{{ __('system.your_comment') }}</label>
                        <textarea id="text" name="text" cols="45" rows="8"></textarea>
                    </p>

                    <div class="clear"></div>
                    <input type="hidden" name="comment_post_ID" id="comment_post_ID" value="{{ $article->id }}">
                    <input type="hidden" name="comment_parent" id="comment_parent" value="0">
                    @csrf
                    <p class="form-submit">
                        <input name="submit" type="submit" id="submit" value="{{ __('system.post_comment') }}"/>
                    </p>
                </form>
            </div>
            <!-- #respond -->
        </div>
        <!-- END COMMENTS -->
        <script src="{{ asset('js/comment-reply.js') }}"></script>
    @endif


@endsection
