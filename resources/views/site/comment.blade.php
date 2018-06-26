@foreach($items as $item)
    <li id="li-comment-{{ $item->id }}"
        class="comment even {{ ($item->user_id == $article->user_id) ?  'bypostauthor odd' : ''}}">
        <div id="comment-{{ $item->id }}" class="comment-container">
            <div class="comment-author vcard">

                <img alt=""
                     src="https://www.gravatar.com/avatar/{{ isset($item->email) ? md5($item->email) : md5($item->user->email) }}?d=mm&s=75"
                     class="avatar" height="75"
                     width="75"/>
                <cite class="fn">{{$item->user->name or $item->name}}</cite>
            </div>
            <!-- .comment-author .vcard -->
            <div class="comment-meta commentmetadata">
                <div class="intro">
                    <div class="commentDate">
                        {{ is_object($item->created_at) ? $item->created_at->format('d.m.Y H:i') : ''}}
                    </div>
                    <div class="commentNumber">#&nbsp;</div>
                </div>
                <div class="comment-body">
                    <p>{{$item->text}}</p>
                </div>
                <div class="reply group">
                    <a class="comment-reply-link" href="#respond"
                       onclick="return addComment.moveForm(&quot;comment-{{$item->id}}&quot;, &quot;{{$item->id}}&quot;, &quot;respond&quot;, &quot;{{$item->article_id}}&quot;)">{{ __('system.reply') }}</a>
                </div>
                <!-- .reply -->
            </div>
            <!-- .comment-meta .commentmetadata -->
        </div>
        <!-- #comment-##  -->

        @if(isset($comments_groups[$item->id]))
            <ul class="children">
                @include('site.comment',['items'=>$comments_groups[$item->id],'comments_groups'=>$comments_groups])
            </ul>
        @endif

    </li>


@endforeach