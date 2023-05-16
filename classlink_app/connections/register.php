<?php
    session_start();
    require '../../vendor/autoload.php';
    require '../../classlink_app/inc/pdo.php';
    use GuzzleHttp\Client;
    use GuzzleHttp\RequestOptions;
    $error = "";
    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    $submit = filter_input(INPUT_POST, "submit");
    $firstname = filter_input(INPUT_POST, "first-name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, "last-name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
    $birth_date = filter_input(INPUT_POST, "birth-date");
    $gender = filter_input(INPUT_POST, "gender");
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password");
    $confirm_password = filter_input(INPUT_POST, "confirm-password");
    $security_question = filter_input(INPUT_POST, "security-question");
    $security_answer = filter_input(INPUT_POST, "security-answer");
    if ($method == 'GET' || ($method == 'POST' && ($password != $confirm_password))):
        if ($password != $confirm_password) {
            $error = 'Les mots de passe ne correspondent pas';
        } ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="../../assets/css/register.css" rel="stylesheet">
            <title>ClassLink - Inscription</title>
        </head>
        <body>
            <div class="container">
                <a href="./landing_page.html"><img src="../../assets/img/logo.svg" alt="Logo de ClassLink" class="logo"></a>

                <div class="white-block">

                </div>
                
                <img src="../../assets/img/moon.svg" alt="Image représentant une lune entouré d'étoile" id="moon">

                <div class="form-block">
                    <h2 class="page-title">S'inscrire</h2>
                    <?php if ($error): ?>
                        <p class="error"><?= $error ?></p>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="full-name">
                            <div class="input-block">
                                <label for="first-name" class="hidden">Prénom: </label>
                                <input type="text" id="first-name" name="first-name" class="input" placeholder="Prénom">
                            </div>

                            <div class="input-block">
                                <label for="last-name" class="hidden">Nom: </label>
                                <input type="text" id="last-name" name="last-name" class="input" placeholder="Nom">
                            </div>
                        </div>
                        

                        <div class="input-block">
                            <label for="mail" class="hidden">Adresse Email: </label>
                            <input type="email" id="mail" name="mail" class="input" placeholder="Adresse Email">
                        </div>
                        

                        <div class="birth-date-gender">
                            <div class="input-block">
                                <label for="birth-date" class="hidden">Date de naissance: </label>
                                <input type="date" name="birth-date" id="birth-date" class="input" placeholder="Date de naissance">
                            </div>

                            <div class="input-block">
                                <label for="gender" class="hidden">Genre: </label>
                                <select name="gender" id="gender" class="input" placeholder="Genre">
                                    <option value="" selected disabled id="default" hidden>Genre</option>
                                    <option value="male">Homme</option>
                                    <option value="female">Femme</option>
                                    <option value="others">Autres</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="input-block">
                            <label for="username" class="hidden">Identifiant: </label>
                            <input type="text" id="username" name="username" placeholder="Identifiant" required class="input">
                        </div>

                        

                        <div class="password">
                            <div class="input-block">
                                <label for="password" class="hidden">Mot de passe: </label>
                                <input type="password" id="password" name="password" placeholder="Mot de passe" required class="input">
                            </div>

                            <div class="input-block">
                                <label for="confirm-password" class="hidden">Confirmez mot de passe: </label>
                                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirmer le mot de passe" required class="input">
                            </div>
                        </div>
                        
                        <?php if(isset($_SESSION['error'])): ?>
                            <p>Username déjà existant</p>
                        <?php endif; ?>

                        <input type="submit" value="Suivant" name="submit" class="button">
                    </form>

                    <p class="paragraph">Déjà inscrit ? <a href="./login.php">Connectez-vous.</a></p>
                </div>
            </div>
            
        </body>
        </html><?php elseif($method =="POST" && $submit == 'Suivant' && ($username && $password && $confirm_password && ($password == $confirm_password))):
            if ($username && $password) {
                $username = trim($username);
                $password = password_hash(trim($password), PASSWORD_DEFAULT);
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['first_name'] = $firstname;
                $_SESSION['last_name'] = $lastname;
                $_SESSION['mail'] = $mail;
                $_SESSION['birth_date'] = $birth_date;
                $_SESSION['gender'] = $gender;
            } ?>
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="../../assets/css/register.css" rel="stylesheet">
                <title>ClassLink - Inscription</title>
            </head>
            <body>
                <div class="container">
                    <a href="./landing_page.html"><img src="../../assets/img/logo.svg" alt="Logo de ClassLink" class="logo"></a>

                    <div class="white-block">

                    </div>

                    <img src="../../assets/img/Moon.svg" alt="Image représentant une lune entouré d'étoile" id="moon">

                    <div class="security-form-block">
                        <form method="POST">
                            <h2 class="page-title">Sécurité</h2>
                            <div class="input-block">
                                <label for="security-question" class="hidden">Question de sécurité: </label>
                                <select name="security-question" id="security-question" class="security-input">
                                    <option value="" selected disabled hidden id="default">Selectionner une question de sécurité.</option>
                                    <option value="first-pet-name">Quel était le nom de votre 1ère animal de compagnie ?</option>
                                    <option value="mother-birth-place">Quel est le lieux de naissance de votre mère.</option>
                                    <option value="first-school-name">Quel est le  nom de votre première école.</option>
                                    <option value="dream-work">Quel est le métier de vos rève ?</option>
                                    <option value="first-love-name">Quel est le nom de votre première amour ?</option>
                                </select>
                            </div>

                            <div class="input-block">
                                <label for="security-answer" class="hidden">Réponse</label>
                                <input type="text" id="security-answer" name="security-answer" placeholder="Réponse" class="security-input">
                            </div>

                            <input type="submit" name="submit" value="Inscription" class="button">
                        </form>
                    </div>
                </div>
                
            </body>
            </html><?php elseif($method =="POST" && $submit == 'Inscription'):
                if ($security_answer) {
                    $client = new \GuzzleHttp\Client();
                    $security_question = trim(filter_input(INPUT_POST, 'security-question'));
                    $security_answer = trim(filter_input(INPUT_POST, 'security-answer', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $data2 = array(
                        'username' => $_SESSION['username'],
                        'password' => $_SESSION['password'],
                        'firstname' => $_SESSION['first_name'],
                        'lastname' => $_SESSION['last_name'],
                        'mail' => $_SESSION['mail'],
                        'birth_date' => $_SESSION['birth_date'],
                        'gender' => $_SESSION['gender'],
                        'question' => $security_question,
                        'answer' => $security_answer,
                    );
                    $json = json_encode($data2);
                    $response = $client->post('http://localhost:8888/SocialNetwork-Fullstack-Project/classlink_authentification/sql/register.php', [
                    // $response = $client->post('http://localhost/SocialNetwork-Fullstack-Project/classlink_authentification/sql/register.php', [
                        'body' => $json
                    ]);
                    $data = json_decode($response->getBody(), true);
                    if($data !== null && isset($data['statut']) && $data['statut'] === 'Succès' ){
                        $id = $data['id']; 
                        
                        $requete_recuperation_profile = $app_pdo->prepare("
                        INSERT INTO profiles (id, birth_date,first_name,last_name,mail,gender)
                        VALUES (:id,:birth_date,:first_name,:last_name,:mail,:gender)
                        ");

                        $requete_recuperation_profile->execute([
                        ":id" => $id ,
                        ":birth_date"=> $_SESSION['birth_date'],
                        ":first_name"=> $_SESSION['first_name'],
                        ":last_name"=> $_SESSION['last_name'],
                        ":mail"=> $_SESSION['mail'],
                        ":gender"=> $_SESSION['gender']
                        ]);
                        header('Location: ../../classlink_app/connections/login.php');
                    }

                    elseif($data["statut"] == 'Erreur'){
                        $_SESSION['error'] = true ;
                        header('Location: ../../classlink_app/connections/register.php');
                    }
                    // $requete_recuperation_profile = $auth_pdo->prepare("
                    // INSERT INTO profiles (birth_date,first_name,last_name,mail,gender)
                    // VALUES (:birth_date, :first_name, :last_name, :mail, :gender)
                    // ");
                
                    // $requete_recuperation_profile->execute([
                    //   "birth_date"=> $birth_date,
                    //   ":first_name"=> $first_name,
                    //   ":last_name"=> $last_name,
                    //   ":mail"=> $mail,
                    //   ":gender"=> $gender
                    // ]);
                }?>
                <?php endif;
?>
