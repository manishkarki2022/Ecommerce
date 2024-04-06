<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password Email</title>
</head>
<body style="font-family: Arial,Helvetica,sans-serif;font-size: 16px">

<p>Hello {{$formData['name']->name}}</p>
<h2>You have requested to change password</h2>
<p>Click on the link below to reset your password</p>
<p><a href="{{route('front.resetPassword', $formData['token'])}}">Reset Password</a></p>

<p>If you did not request to change password, please ignore this email</p>
<p>Thanks</p>



</body>
</html>
