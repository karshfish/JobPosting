<h1>Your Applications</h1>

<table>
    <tr>
        <th>Job</th>
        <th>Status</th>
    </tr>
    @foreach($applications as $application)
    <tr>
        <td>{{ $application->job->title }}</td>
        <td>{{ $application->status }}</td>
    </tr>
    @endforeach
</table>
