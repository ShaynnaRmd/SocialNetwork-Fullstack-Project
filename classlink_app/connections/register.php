<?php
    require '../../vendor/autoload.php';
    require '../../classlink_app/inc/pdo_authentification.php';
    use GuzzleHttp\Client;
    use GuzzleHttp\RequestOptions;
    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    $submit = filter_input(INPUT_POST, "submit");
    $firstname = filter_input(INPUT_POST, "first-name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, "last-name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
    $age = filter_input(INPUT_POST, "age");
    $gender = filter_input(INPUT_POST, "gender");
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password");
    $security_question = filter_input(INPUT_POST, "security-question");
    $security_answer = filter_input(INPUT_POST, "security-answer");
    if ($method == 'GET'): ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>ClassLink - Inscription</title>
        </head>
        <body>
            <h1>ClassLink</h1>
            <div>
                <h2>S'inscrire</h2>
                <form method="POST">
                    <label for="first-name">Prénom: </label>
                    <input type="text" id="first-name" name="first-name">

                    <label for="last-name">Nom: </label>
                    <input type="text" id="last-name" name="last-name">

                    <label for="mail">Adresse Email: </label>
                    <input type="email" id="mail" name="mail">

                    <label for="age">Age: </label>
                    <input type="number" name="age" id="age">

                    <label for="gender">Genre: </label>
                    <select name="gender" id="gender">
                        <option value="male">Homme</option>
                        <option value="female">Femme</option>
                        <option value="others">Autres</option>
                    </select>

                    <label for="username">Identifiant: </label>
                    <input type="text" id="username" name="username" placeholder="Identifiant" required>

                    <label for="password">Mot de passe: </label>
                    <input type="password" id="password" name="password" placeholder="Mot de passe" required>
                    <?php
                    if(isset($_SESSION['error'])){ ?>
                    
                    <p>Username déjà existant</p>

                    <?php }
                    ?>
                    <input type="submit" value="Suivant" name="submit">
                </form>

                <p>Déjà inscrit ? <a href="">Connectez-Vous.</a></p>
            </div>
        </body>
        </html><?php elseif($method =="POST" && $submit == 'Suivant'):
            if ($username && $password) {
                $username = trim($username);
                $password = password_hash(trim($password), PASSWORD_DEFAULT);
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
                $_SESSION['mail'] = $mail;
                $_SESSION['age'] = $age;
                $_SESSION['gender'] = $gender;
            } ?>
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>ClassLink - Inscription</title>
            </head>
            <body>
                <h1>ClassLink</h1>
                <div>
                    <h2>Sécurité</h2>
                    <form method="POST">
                        <label for="security-question">Question de sécurité: </label>
                        <select name="security-question" id="security-question">
                            <option value="first-pet-name">Quel est le nom de votre 1ère animal de compagnie ?</option>
                            <option value="mother-birth-place">Quel est le lieux de naissance de votre mère.</option>
                            <option value="first-school-name">Quel est le  nom de votre première école.</option>
                            <option value="dream-work">Quel est le métier de vos rève ?</option>
                            <option value="first-love-name">Quel est le nom de votre première amour ?</option>
                        </select>

                        <label for="security-answer">Réponse</label>
                        <input type="text" id="security-answer" name="security-answer">

                        <input type="submit" name="submit" value="Inscription">
                    </form>
                </div>
            </body>
            </html><?php elseif($method =="POST" && $submit == 'Inscription'):
                if ($security_answer) {
                    $client = new \GuzzleHttp\Client();
                    $security_question = trim(filter_input(INPUT_POST, 'security-question'));
                    $security_answer = trim(filter_input(INPUT_POST, 'security-answer', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $data = array(
                        'username' => $_SESSION['username'],
                        'password' => $_SESSION['password'],
                        'first_name' => $_SESSION['firstname'],
                        'last_name' => $_SESSION['lastname'],
                        'mail' => $_SESSION['mail'],
                        'age' => $_SESSION['age'],
                        'gender' => $_SESSION['gender'],
                        'question' => $security_question,
                        'answer' => $security_answer
                    );
                    $json = json_encode($data);
                    // $response = $client->post('http://localhost:8888/SocialNetwork-Fullstack-Project/classlink_authentification/sql/register.php', [
                    $response = $client->post('http://localhost/SocialNetwork-Fullstack-Project/classlink_authentification/sql/register.php', [
                        'body' => $json
                    ]);
                    $data = json_decode($response->getBody(), true);
                    if($data['statut'] == 'Succès'){
                        header('Location: ../../classlink_app/connections/login.php');
                    }
                    elseif($data["statut"] == 'Erreur'){
                        $_SESSION['error'] = true ;
                        header('Location: ../../classlink_app/connections/register.php');
                    }
                }?>
                <?php endif;
?>