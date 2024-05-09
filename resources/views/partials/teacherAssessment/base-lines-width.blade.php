

<div class="custom_1" style="width: {{$width}}px;white-space: normal;word-break: normal;">
    @foreach($data as $value)
        @if(is_array($value))
            @foreach($value as $v)
                @if($v != '')
                    <li>
                        {{ $v }}
                    </li>
                @endif
            @endforeach
        @else
            @if($value != '')
                <li>
                    {{ $value }}
                </li>
            @endif

        @endif

    @endforeach
</div>
