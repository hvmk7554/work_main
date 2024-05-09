@if(empty($link))
    <span>
        {{ $link_title }}
    </span>
@else
    <a class="link-default" target="_blank" href="{{$link}}">{{ $link_title }}</a>
@endif
