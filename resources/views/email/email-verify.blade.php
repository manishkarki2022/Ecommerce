<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Please Verify your email</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 16px;">

<p>Hello {{ $formData['name']->name }}</p>
<p>Click on the link below to verify your email</p>
<p><a href="{{ route('verify.email', ['token' => $formData['token']]) }}">Verify your email</a></p>

<p>If you did not request to verify your email, please ignore this email</p>
<p>Thanks</p>

</body>
</html>
