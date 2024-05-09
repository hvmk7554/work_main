<table>
    <thead>
    <tr>
        @foreach($headers as $header)
            <th>{{ $header }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        <tr>
            @foreach($row as $value)
                <td>{{ $value }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
