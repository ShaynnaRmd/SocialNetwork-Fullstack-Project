<?php
    session_start();
    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    if ($method =="POST") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($username && $password) {
            $data = array(
                "login" => $username,
                "password" => $password
            );
        }
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassLink - Connection</title>
</head>
<body>
    <h1>ClassLink</h1>
    <div>
        <h2>Se connecter</h2>
        <form action="" method="POST">
            <label for="username">Identifiant: </label>
            <input type="text" id="username" name="username" placeholder="Identifiant" required>

            <label for="password">Mot de passe: </label>
            <input type="password" id="password" name="password" placeholder="Mot de passe" required>

            <input type="submit" value="Connexion">
        </form>
        <p>Pas encore inscrit ? <a href="">Cliquez ici</a></p>
        <a href="">Mot de passe oublié ?</a>
    </div>
</body>
</html>