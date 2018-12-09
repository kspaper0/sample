<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Activation Link</title>
</head>

<body>
    <h1>Thanks for your registering</h1>

    <p>
        Please click the following link to finish your registration:

        <a href="{{ route('confirm_email', $user->activation_token) }}">
            {{ route('confirm_email', $user->activation_token) }}
        </a>
    </p>

    <hr>

    <p>
       Please do not reply, Thanks.
    </p>
</body>
</html>