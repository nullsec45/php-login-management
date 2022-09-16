<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $model["title"]; ?></title>
</head>
<body>
    <h1><?= $model["body"]; ?></h1>
    <p>User saat ini:<?= $_SESSION["username"]; ?></p>
    <p>Password:<?= $_SESSION["password"]; ?></p>
</body>
</html>