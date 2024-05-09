<div class="custom_1" style="width: 300px;white-space: normal">
    @foreach($exam_attempts as $exam_attempt)
        @if($exam_attempt['finished'] > 0)
            <li>
                <b>{{ $exam_attempt['name'] }} : </b> Hoàn thành {{ $exam_attempt['finished'] }} / {{ $exam_attempt['amounts'] }} đã được giao (đạt {{ $exam_attempt['average_finished'] }} ) <br>
                điểm trung bình đạt {{ $exam_attempt['average_score'] }}.
            </li>
        @else
            <li>
                <b>{{ $exam_attempt['name'] }} : </b> Hoàn thành {{ $exam_attempt['finished'] }} / {{ $exam_attempt['amounts'] }} đã được giao (đạt {{ $exam_attempt['average_finished'] }} ) <br>
            </li>
        @endif
    @endforeach

</div>
