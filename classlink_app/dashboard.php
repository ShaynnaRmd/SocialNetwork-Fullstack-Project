<?php
session_start();
require './inc/functions/token_functions.php';
require './inc/pdo.php';
    if(isset($_SESSION['token'])){
        $check = token_check($_SESSION["token"], $auth_pdo);
        if($check == 'false'){
            header('Location: ./connections/login.php');
            exit();
        } elseif($_SESSION['profile_status'] == 'Inactif') {
            header('Location: ./profiles/settings.php');
            exit();        
        }
    }elseif(!isset($_SESSION['token'])){
        header('Location: ./connections/login.php');
        exit();
    }

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
        $age = 'Non renseignée';
    } else {
        $current_date = new DateTime();
        $birth_date = new DateTime($birth_date);
        $diff = $current_date->diff($birth_date);
        $age = $diff->y;
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
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <title>Document</title>
</head>
<body>
    <?php include './inc/tpl/header.php' ?>
    <main>
        <div class='dashboard-leftside'>
            <div class="informations">
                <div class="top">
                        <div class="img"><img src="../../assets/img/default_pp.jpg" alt=""></div>
                        <div class="name">
                            <p><?= "$firstname $lastname" ?></p>
                        </div>
                    <div class="separator"></div>
                </div>
                <div class="mid">
                    <div class="personnal-info">
                            <div><p>Age <span>: <?= $age ?></span></p></div>
                            <div><p>Genre <span>: <?= $gender ?></span></p></div>
                            <div><p>E-mail <span>: <?= $mail ?></span></p></div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="btn2"><button id="modify-profile-btn">Modifier</button></div> <!-- Rajouter le lien vers modifier profil--> 
                </div>
            </div>
            <div class='relations-groups-pages'>
                <div>
                    <div class='text-number'>
                        <div class='txt'><p>Relations</p></div>
                        <div><p><?= $numbers_of_relations ?></p></div>
                    </div>
                    <div class='separator2'></div>
                </div>
                <div>
                    <div class='text-number'>
                        <div class='txt'><p>Groups</p></div>
                        <div><p>4</p></div>
                    </div>
                    <div class='separator2'></div>
                </div>
                <div>
                    <div class='text-number'>
                        <div class='txt'><p>Pages</p></div>
                        <div><p><?= $numbers_of_pages ?></p></div>
                    </div>
                </div>
            </div>
            <div class="btn">
                <button id="logout">Se déconnecter</button> <!-- Rajouter le lien vers logout--> 
            </div>
        </div>
        <div class='dashboard-mid'>
            <div class="create-post" id='create-post'>
                <div class="pp-post"><img src="" alt=""></div>
                <div class="fake-input"><p>Exprimez-vous...</p></div>
            </div>
            <!-- <div class="post">
        <div class="top-post">
            <div class="post-pp"><img src="" alt=""></div>
            <div class="post-name"><p>Djedje Gboble</p></div>
            <div class="post-text"><p>lorem ipsum</p></div>
            <div class="post-date"><p>Le 27/06/2023, à 22:47</p></div>
            <div class="plus"><p>Afficher plus...</p></div>
        </div>
        <div class="img-post" id="picspost" style="background-image: url('<?= $path_img.$image ?>')"></div>
        <div class="bottom-post">
            <div class="up">
                <div class="nb-like">
                    <div><img src="../assets/img/thumbs-up.svg" alt=""></div>
                    <div><img src="../assets/img/heart.svg" alt=""></div>
                    <div><img src="../assets/img/smile.svg" alt=""></div>
                    <div class="nb"><p>3125</p></div>
                </div>
                <div class="nb-comments"><p>134 Commentaires</p></div>
            </div>
            <div class="down">
                <div class='left'>
                    <div><img src="../assets/img/thumbs-up.svg" alt=""></div>
                    <div class="text"><p>J'aime</p></div>
                </div>
                <div class="right">
                    <div><img src="../assets/img/comment.svg" alt=""></div>
                    <div class="text"><p>Commenter</p></div>
                </div>
            </div> -->
            </div>
        <div class='dashboard-right'>
            <div class='suggestions'>
                <div class='suggestions-personnes'>
                    <div><h3>Suggestions</h3></div>
                    <div class='personnes'>
                        <div><h5>Personnes :</h5></div>
                        <div class='list'>
                            <div>
                                <div class='list-img'><img src="../assets/img/default_pp.jpg" alt=""></div>
                                <div class='list-p'><p>Nom Prénom</p></div>
                                <div><button></button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
    <!-- <div class="link">
    <h1>Test</h1>
    <a href="./connections/logout.php">Déconnexion</a>
    <a href="./pages/create_page.php">Créer une page</a>
    <a href="./profiles/profile.php">PROFIL</a> -->
    <script src="../assets/js/notifications.js"></script>
    <script>
        const logoutButton = document.getElementById('logout');
        logoutButton.addEventListener('click', () => {
            window.location.href = './connections/logout.php';
        })

        const modifyProfileBtn = document.getElementById('modify-profile-btn');
        modifyProfileBtn.addEventListener('click', () => {
            window.location.href = './profiles/settings_edition_mode.php';
        })
    </script>
</body>
</html>