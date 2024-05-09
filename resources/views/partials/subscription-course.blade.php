<ul>
    @if($subjects['available'] != [])
    <li>
    @foreach ($subjects['available'] as $subject)
            @if($loop->last)
                <a style="color:#0000FF" href="/resources/curricula/{{$subject["id"]}}">{{ $subject["title"] ?? "" }}</a>
            @else
                <a style="color:#0000FF" href="/resources/curricula/{{$subject["id"]}}">{{ $subject["title"] ?? "" }} , </a>
            @endif
    @endforeach
    </li>
    @endif
</ul>
<ul>
    @if($subjects['available_under_14'])
    <li>
        @foreach ($subjects['available_under_14'] as $subject)
            @if($loop->last)
                <a style="color:#5bd231; text-decoration: underline" href="/resources/curricula/{{$subject["id"]}}">{{ $subject["title"] ?? "" }} </a>
            @else
                <a style="color:#5bd231; text-decoration: underline" href="/resources/curricula/{{$subject["id"]}}">{{ $subject["title"] ?? "" }} , </a>
            @endif
        @endforeach
    </li>
    @endif
</ul>
<ul>
    @if($subjects['expired_under_30'])
    <li>
        @foreach ($subjects['expired_under_30'] as $subject)
            @if($loop->last)
                <a style="color:#8a8a8a; text-decoration: underline" href="/resources/curricula/{{$subject["id"]}}">{{ $subject["title"] ?? "" }} </a>
            @else
                <a style="color:#8a8a8a; text-decoration: underline" href="/resources/curricula/{{$subject["id"]}}">{{ $subject["title"] ?? "" }} , </a>
            @endif
        @endforeach
    </li>
    @endif
</ul>
<ul>
    @if($subjects['expired_sub_over_30'])
    <li>
        @foreach ($subjects['expired_sub_over_30'] as $subject)
            @if($loop->last)
                <a style="color:#8a8a8a" href="/resources/curricula/{{$subject["id"]}}">{{ $subject["title"] ?? "" }} </a>
            @else
                <a style="color:#8a8a8a" href="/resources/curricula/{{$subject["id"]}}">{{ $subject["title"] ?? "" }} , </a>
            @endif
        @endforeach
    </li>
    @endif
</ul>

