<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Send Email Demo</title>
</head>
<body>
    <h1>Send Email Demo</h1>

    <form action="{{ route('resend.send') }}" method="POST">
        @csrf
        <label for="to">To:</label>
        <input type="email" name="to" id="to" required>
        <br><br>
        <label for="subject">Subject:</label>
        <input type="text" name="subject" id="subject" required>
        <br><br>
        <label for="body">Body:</label>
        <textarea name="body" id="body" rows="5" required></textarea>
        <br><br>
        <button type="submit">Send Email</button>
    </form>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
</body>
</html>