<ul>
    @foreach ($urls as $url)
        <li>
            <a href="{{$url}}">File {{$loop->index + 1}}</a>
        </li>
    @endforeach
</ul>
