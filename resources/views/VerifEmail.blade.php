<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>
<body>
    <h1>Verifikasi Email</h1>
    Please verify your email with bellow link: 
    {{-- <a href="{{ route('user.verif', $token) }}">Verify Email</a> --}}
    <a href="{{ env('APP_FRONT').'/verif-email/'.$token }}">Verify Email</a>
</body>
</html>