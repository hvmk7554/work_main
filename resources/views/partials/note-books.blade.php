<ul>
    @foreach ($noteBooks as $noteBook)
        <li>
            {{isset($books[$noteBook]) ? $books[$noteBook] : $noteBook}}
            @if ($noteBook == 'other')
                :{{$otherSchoolNoteBook}}
            @endif
        </li>
    @endforeach
</ul>
