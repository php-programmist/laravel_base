@foreach($items as $item)
    @if($item->hasParent())
        <li class="{{ url()->current() == $item->url() ? 'active' : '' }} {{$item->hasChildren()?'dropdown':''}} nav-item">
    @else
        <li class="{{ url()->current() == $item->url() ? 'active' : '' }} {{$item->hasChildren()?'dropdown':''}} nav-item">
            @endif

            @if($item->hasChildren())
                <a class="dropdown-toggle {{ $isChild?'dropdown-item':'nav-link' }}"
                   data-toggle="dropdown" href="{{ $item->url() }}">{{ $item->title }} <span class="caret"></span></a>

                <ul class="dropdown-menu">
                    @include('site.customMenuItems',['items'=>$item->children(),'isChild'=>true])
                </ul>
            @else

                <a class="{{ $isChild?'dropdown-item':'nav-link' }}" href="{{ $item->url() }}">{{ $item->title }}</a>

            @endif

        </li>
        @endforeach
        {{--
        @foreach($items as $item)
            <li @lm-attrs($item) @if($item->hasChildren()) class="nav-item dropdown" @endif @lm-endattrs>
                @if($item->link) <a @lm-attrs($item->link) @if($item->hasChildren()) class="nav-link dropdown-toggle"
                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @else
                        class="nav-link" @endif @lm-endattrs href="{!! $item->url() !!}">
                    {!! $item->title !!}
                    @if($item->hasChildren()) <b class="caret"></b> @endif
                </a>
                @else
                    <span class="navbar-text">{!! $item->title !!}</span>
                @endif
                @if($item->hasChildren())
                    <ul class="dropdown-menu">
                        @include('site.customMenuItems',['items'=>$item->children()])
                    </ul>
                @endif
            </li>
            @if($item->divider)
                <li{!! Lavary\Menu\Builder::attributes($item->divider) !!}></li>
            @endif
        @endforeach--}}
