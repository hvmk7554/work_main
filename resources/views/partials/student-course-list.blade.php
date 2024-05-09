@foreach ($courses as $course)
    @if($loop->last)
        <b>{{ $course ?? "" }} </b>
    @else
        <a>{{ $course ?? "" }} ,</a>
    @endif
@endforeach
