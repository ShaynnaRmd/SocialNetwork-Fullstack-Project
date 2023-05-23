<?php
    session_start();
    require '../inc/pdo.php';
    require '../inc/functions/token_functions.php';
    if(!isset($_SESSION['id'])){
        // $check = token_check($_SESSION["token"], $auth_pdo);
        // if($check == 'false'){
            header('Location: ../connections/login.php');
        }
    // }elseif(!isset($_SESSION['token'])){
    //     header('Location: ../connections/login.php');
    // }

    $path_img = 'http://localhost/SocialNetwork-Fullstack-Project/classlink_app/profiles/uploads/';

    // Préparation de la requète permettant de récupérer toute les infos lié à ce profile via l'id
    $account_info_request =  $app_pdo->prepare("
        SELECT * FROM profiles
        WHERE id = :id;
    ");

    // Execution de la requète avec l'id passez en session
    $account_info_request->execute([
        ":id" => $_SESSION['id']
    ]);

    // Récupération du résultat de la requète
    $result = $account_info_request->fetch(PDO::FETCH_ASSOC);

    // Variables contenant les informations du compte, suivi d'une condition qui permettra d'afficher non renseigné si la variable contient null
    $lastname = $result['last_name'];
    if ($lastname == null) {
        $lastname = 'Non renseigné';
    }
    $firstname = $result['first_name'];
    if ($firstname == null) {
        $firstname = 'Non renseigné';
    }
    $username = $result['username'];
    $birth_date = $result['birth_date'];
    if ($birth_date == null) {
        $birth_date = 'Non renseignée';
    }
    $gender = $result['gender'];
    switch ($gender) {
        case 'male':
            $gender = 'Homme';
            break;
        case 'female':
            $gender = 'Femme';
            break;
        case 'other':
            $gender =  'Autre';
            break;
        default:
            $gender = 'Non renseigné';
            break;
    }

    $mail = $result['mail'];
    if ($mail == null) {
        $mail = 'Non renseigné';
    }

    $banner_image = $result['banner_image'];

    $profile_activity_request = $app_pdo->prepare("
        SELECT 
        (SELECT COUNT(creator_profile_id) FROM pages WHERE creator_profile_id = :id) AS `numbers_of_pages`,
        (SELECT COUNT(profile_id) FROM publications_profile WHERE profile_id = :id) AS `numbers_of_publications`,
        (SELECT COUNT(id) FROM relations WHERE user_profile_id = :id) AS `numbers_of_relations` 
    ");

    $profile_activity_request->execute([
        ":id" => $_SESSION['id']
    ]);

    $profile_activity_result = $profile_activity_request->fetch(PDO::FETCH_ASSOC);
    $numbers_of_pages = $profile_activity_result["numbers_of_pages"];
    $numbers_of_publications = $profile_activity_result["numbers_of_publications"];
    $numbers_of_relations = $profile_activity_result["numbers_of_relations"];

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/settings.css">
    <title>Profile - Paramètres</title>
</head>
<body>
    <header></header>
    <main>
        <div class="settings-infos">
            <div class="header">
                <div><p>Informations du profil</p></div>
            </div>
            <div class="main">
                <div class="user-infos">
                    <div><p>Nom : </p></div>
                    <div><p>Prénom : </p></div>
                    <div><p>Age : </p></div>
                    <div><p>Genre : </p></div>
                    <div><p>Email : </p></div>
                    <div><p>Identifiant : </p></div>
                    <div><p>Mot de passe : </p></div>
                </div>
                <div class='user-response'>
                    <div><p><?= $lastname ?></p></div>
                    <div><p><?= $firstname ?></p></div>
                    <div><p><?= $birth_date ?></p></div>
                    <div><p><?= $gender ?></p></div>
                    <div><p><?= $mail ?></p></div>
                    <div><p><?= $username ?></p></div>
                    <div><p>******</p></div>
                </div>
            </div>
            <div class='footer'>
                <div><button id="modify-profile-btn">Modifier les informations</button></div>
            </div>
        </div>
        <div class="settings-profil">
            <div class="banner_button">
                <div class="banner">
                    <img src="./assets/img/default-banner.png" alt="" />
                </div>
                <div class="buttons">
                    <div class="div-buttons">
                        <div class="btn1"><button>Modifier profil</button></div>
                        <div class="btn2"><button>Modifier couverture</button></div>
                    </div>
                </div>
                <div class="pp"><img src="./assets/img/default_pp.jpg" alt=""></div>
            </div>
            <div class="activity">
                <div class="header"><div><p>Activité du profil</p></div></div>
                <div class="main">
                    <div class="list">
                        <div class="element-list"><div class=><p>Relations :</p></div><div><span><?= $numbers_of_relations ?></span></div></div>
                        <div class="element-list"><div><p>Groupes :</p></div><div><span>57</span></div></div>
                        <div class="element-list"><div><p>Pages :</p></div><div><span><?= $numbers_of_pages ?></span></div></div>
                        <div class="element-list"><div><p>Nombre de posts :</p></div><div><span><?= $numbers_of_publications ?></span></div></div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="button-list">
                        <div class="btn1"><button>Désactiver le compte</button></div>
                        <div class="btn2"><button>Supprimer le compte</button></div>
                    </div>
                <div class="btn3"><button id="logout">Se déconnecter</button></div>
                </div>
            </div>
        </div>
    </main>
    <script>
        const modifyProfileBtn = document.getElementById('modify-profile-btn');
        modifyProfileBtn.addEventListener('click', () => {
            window.location.href = './settings_edition_mode.php';
        })

        const logoutBtn = document.getElementById('logout');
        logoutBtn.addEventListener('click', () => {
            window.location.href = '../connections/logout.php';
        })
    </script>
</body>
</html>