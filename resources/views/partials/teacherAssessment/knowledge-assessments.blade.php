<div class="custom_1" style="width: 300px;white-space: normal">
    @foreach($assessment_results as $assessment)
        <b>{{ array_search($assessment, $assessment_results) }} : </b>
        @foreach($assessment as $data)
            <li>
                {{ $data['lesson'] }} ({{ $data['score'] }})
            </li>
        @endforeach
    @endforeach
</div>

