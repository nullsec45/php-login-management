<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Halaman Login</h1>
    <form action="/login" method="POST">
        <p>
            <label for="username">username</label>
            <input type="text" name="username" id="username" name="username">
        </p>

        <p>
            <label for="password">password</label>
            <input type="password" name="password" id="password" id="password">
        </p>
        <button type="submit">Login</button>
    </form>
</body>
</html>