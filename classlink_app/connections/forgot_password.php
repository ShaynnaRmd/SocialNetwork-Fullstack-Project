<?php
    use GuzzleHttp\Client;
    use GuzzleHttp\RequestOptions;
    require '../inc/pdo.php';
    require '../../vendor/autoload.php';
    session_start();

    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    $submit = filter_input(INPUT_POST, "submit");

    if ($method == "POST") {
        $client = new \GuzzleHttp\Client();
        $username = trim(filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    

        if ($username){
            $data = [
                "username" => $username
            ];

            $json = json_encode($data);
            // echo $json;

            $response = $client->post('http://localhost/SocialNetwork-Fullstack-Project/classlink_authentification/sql/forgot_password.php', [     
                'body' => $json
            ]);

            $data = json_decode($response->getBody(), true);

            if(isset($data)){
                if($data['statut'] == 'Succès'){
                    echo $data['statut'];
                    $_SESSION['id'] = $data['id'];
                    $existing_user = true ;
                    exit();
                }elseif($data['statut'] == 'Erreur'){
                    echo $data['statut'];
                    $invalid_user = true;
                }
            }
        }
    }
        
    
    ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="../../assets/css/forgot_password.css" rel="stylesheet">
            <title>ClassLink - Mot de passe oublié</title>
        </head>
        <body>

            <div class="container">
                <a href="../../classlink_app/connections/landing_page.html"><img class="logo" src="../../assets/img/logo.svg" alt="logo"></a>
                <div class='background-right'></div>
                <img class="planet" src="../../assets/img/planet.svg" alt="planet_stars">

                <h2>Mot de passe oublié</h2>

                <div class="forgot-password-form">
                    <form method="POST">
                        <label class="username-label" for="username">Identifiant : </label>
                        <input class="username-input" type="text" id="username" name="username" placeholder="Identifiant" required>
                        
                        <div class="button-container">
                            <input class="button" type="submit" name="submit" value="Suivant">
                            <a href="./login.php"><button class="cancel-button" type="button">Annuler</button></a>
                        </div>

                        <?php if (isset($invalid_user)){
                            echo $data['message'];
                        }?>
                            <!-- <p>Aucun compte associé à cet identifiant. Veuillez réessayer.</p> -->
                    </form>
                </div>
            </div>

        </body>
        </html>