<?php
    session_start();
    require '../../vendor/autoload.php';
    require '../inc/pdo_authentification.php';
    use GuzzleHttp\Client;
    use GuzzleHttp\RequestOptions;
    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

    if ($method == "POST") {
        $client = new \GuzzleHttp\Client();
        $username = trim(filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $password = trim(filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if ($username && $password) {

            $data = [
                "username" => $username,
                "password" => $password
            ];

            $json = json_encode($data);
            $response = $client->post('http://localhost/SocialNetwork-Fullstack-Project/classlink_authentification/sql/login.php', [
                'body' => $json
            ]);
            $data = json_decode($response->getBody(), true);
            if(isset($data)){
                if($data['statut'] == 'Succès'){
                    $_SESSION['token'] = $data['message'];
                    header("Location: ../dashboard.php");
                    exit();
                }elseif($data['message'] == 'Identifiants incorrects'){
                    $erreur = true;
                }elseif($data['message'] == 'Utilisateur inexistant'){
                    $invalid_user = true;
                }
            }
        }
    }   
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/login.css">
    <title>ClassLink - Connection</title>
</head>
<body>
    <a href="../../classlink_app/landing_page.html"><img class="logo" src="../../assets/img/logo.svg" alt="logo"></a>
    <div>
        <div class='background-right'></div>
        <img class="planet" src="../../assets/img/planet.svg" alt="planet_stars">
        <h2>Se connecter</h2>
        <form action="" method="POST">
            <label class="username-label" for="username">Identifiant: </label>
            <input class="username-input" type="text" id="username" name="username" placeholder="Identifiant" required>
            <label class="password-label" for="password">Mot de passe: </label>
            <?php if(isset($erreur)){ ?>
                <p>Identifiants incorrects</p>
            <?php } ?>
            <?php if(isset($invalid_user)){ ?>
                <p>Le nom d'utilisateur n'existe pas</p>
            <?php } ?>
            <input class="password-input" type="password" id="password" name="password" placeholder="Mot de passe" required>
            <input class="connexion" type="submit" value="Connexion">
        </form>
        <div class="redirect">
            <p>Pas encore inscrit ? <a href="./register.php">Cliquez ici</a></p>
            <a href="">Mot de passe oublié ?</a>
        </div>
    </div>
</body>
</html>