<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Email</title>
</head>
<body style="font-family: Arial,Helvetica,sans-serif;font-size: 16px">
<h2>You have received a contact email</h2>
<p>Name: {{$mailData['name']}}</p>
<p>Email: {{$mailData['email']}}</p>
<p>Subject: {{$mailData['subject']}}</p>


<p>Message:</p>
<p>{{$mailData['message']}}</p>


</body>
</html>
