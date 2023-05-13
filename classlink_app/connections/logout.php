<?php
    session_start();
    sleep(5);
    session_destroy();
    header('Location: ./login.php')
?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion</title>
</head>
<body>
    <h1>ClassLink</h1>
    <p>Merci de votre visite. <span>À bientôt sur ClassLink !</span></p>
    <p>Vous allez être redirigé dans 5 secondes...</p>
</body>
</html>