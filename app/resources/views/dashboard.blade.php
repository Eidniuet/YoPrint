<!DOCTYPE html>
<html>
<head>
    <title>File Upload Dashboard</title>
</head>
<body>
    <h1>File Upload Dashboard</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="csv_file">
        <button type="submit">Upload File</button>
    </form>

    <h2>Recent Uploads</h2>
    <table>
        <thead>
            <tr>
                <th>Upload Time</th>
                <th>File Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($uploads as $upload)
                <tr>
                    <td>{{ $upload->upload_time }}</td>
                    <td>{{ $upload->file_name }}</td>
                    <td>{{ $upload->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

