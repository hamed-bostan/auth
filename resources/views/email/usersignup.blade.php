<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registering</title>
</head>
<body>

<h2>Hi {{ $first_name }}</h2>
<p>Your registration was successful, To activate your account click on link blow</p>

<a href={{ env('EMAIL_ACTIVE_LINK_PREFIX') . $activation_token }}>Activating account</a>
</body>
</html>
