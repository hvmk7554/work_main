@foreach($data as $value)
    @if ( $value['lifecycle'] == "deactive")
        <li>
            <a href="{{$url}}/resources/teachers/{{$value['id']}}" class="link-default">
                {{ $value['name'] }}(deactive)
            </a>
        </li>
    @else
        <li>
            <a href="{{$url}}/resources/teachers/{{$value['id']}}" class="link-default">
                {{ $value['name'] }}
            </a>
        </li>
    @endif

@endforeach
