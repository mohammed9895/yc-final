<!DOCTYPE html>
<html>

<head>
    <title>{{ $subject }}</title>
</head>

<body>
    <ul>
        <li>Name: {{ $fullname }}</li>
        <li>Email: {{ $email }}</li>
        <li>Phone: {{ $phone }}</li>
        <li>Subject: {{ $subject }}</li>
    </ul>

    <p>
        {{ $messages }}
    </p>

</body>

</html>
