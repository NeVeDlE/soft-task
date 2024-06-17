<!DOCTYPE html>
<html>
<head>
    <title>File Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>File Details</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>File Name:</strong> {{ $fileName }}</p>
            <p><strong>File Size:</strong> {{ $fileSize }} bytes</p>
            <p><strong>File Extension:</strong> {{ $fileExtension }}</p>
        </div>
    </div>

    <div class="mt-5">
        <h3>Encrypt File</h3>
        <form action="/encrypt" method="post">
            @csrf
            <input type="hidden" name="file_path" value="{{ $path }}">
            <div class="form-group">
                <label for="encrypt-key">Encryption Key</label>
                <input type="text" class="form-control" id="encrypt-key" name="key" placeholder="Enter encryption key" required>
            </div>
            <div class="form-group">
                <label for="encrypt-file-name">File Name</label>
                <input type="text" class="form-control" id="encrypt-file-name" name="file_name" placeholder="Enter file name for encrypted file" required>
            </div>
            <button type="submit" class="btn btn-primary">Encrypt</button>
        </form>
    </div>

    <div class="mt-5">
        <h3>Decrypt File</h3>
        <form action="/decrypt" method="post">
            @csrf
            <input type="hidden" name="file_path" value="{{ $path }}">
            <div class="form-group">
                <label for="decrypt-key">Decryption Key</label>
                <input type="text" class="form-control" id="decrypt-key" name="key" placeholder="Enter decryption key" required>
            </div>
            <div class="form-group">
                <label for="decrypt-file-name">File Name</label>
                <input type="text" class="form-control" id="decrypt-file-name" name="file_name" placeholder="Enter file name for decrypted file" required>
            </div>
            <button type="submit" class="btn btn-primary">Decrypt</button>
        </form>
    </div>
</div>
</body>
</html>
