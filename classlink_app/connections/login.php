<?php
    // session_start();
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
            var_dump($data);
    //         if(isset($data)){
    //             if($data['statut'] == 'Succès'){
    //                 $_SESSION['token'] = $data['message'];
    //                 header("Location: ../dashboard.php");
    //                 exit();
    //             }elseif($data['statut'] == 'Erreur'){
    //                 $erreur = true;
    //             }
    //         }
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
            <?php if(isset($erreur)){ ?>
                <p>Identifiants incorrects</p>
            <?php } ?>
            <input type="submit" value="Connexion">
        </form>
        <p>Pas encore inscrit ? <a href="./register.php">Cliquez ici</a></p>
        <a href="">Mot de passe oublié ?</a>
        <a href="./logout.php">Déconnexion</a>
    </div>
</body>
</html>