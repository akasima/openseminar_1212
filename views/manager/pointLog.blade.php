<table class="table table-hover">
    <thead>
        <th>아이디</th>
        <th>포인트</th>
        <th>등록일시</th>
    </thead>

    <tbody>
    @foreach($list as $log)
        <tr>
            <td>{{ $log->userId }}</td>
            <td>{{ $log->point }}</td>
            <td>{{ $log->createdAt }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
