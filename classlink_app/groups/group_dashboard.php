<?php
session_start();
require '../inc/pdo.php';
require '../inc/functions/token_functions.php';

if(isset($_SESSION['token'])){
    $check = token_check($_SESSION["token"], $auth_pdo);
    if($check == 'false'){
        header('Location: ../connections/login.php');
        exit();
    } elseif($_SESSION['profile_status'] == 'Inactif') {
        header('Location: ../profiles/settings.php');
        exit();        
    }
}elseif(!isset($_SESSION['token'])){
    header('Location: ../connections/login.php');
    exit();
}

$requete = $app_pdo->prepare('
    SELECT group_id 
    FROM group_members
    WHERE profile_id = :profile_id;
');
$requete->execute([
    ':profile_id' => $_SESSION['id']
]);
$result = $requete->fetchAll(PDO::FETCH_ASSOC);

$group_id = array();
for ($i = 0; $i < count($result); $i++) {
    array_push($group_id, $result[$i]['group_id']);
}

$title = "Groupes rejoints";

$requete2 = $app_pdo->prepare('
    SELECT DISTINCT gm.group_id, g.name, g.description, g.status,g.id
    FROM group_members gm
    JOIN groups_table g ON gm.group_id = g.id
    WHERE gm.profile_id = :profile_id;
');
$requete2->execute([
    ':profile_id' => $_SESSION['id']
]);
$result2 = $requete2->fetchAll(PDO::FETCH_ASSOC);

$requete3 = $app_pdo->prepare('
    SELECT DISTINCT gm.group_id, g.name, g.description, g.status,g.id
    FROM group_members gm
    JOIN groups_table g ON gm.group_id = g.id
    WHERE gm.profile_id != :profile_id;
');
$requete3->execute([
    ':profile_id' => $_SESSION['id']
]);
$result3 = $requete3->fetchAll(PDO::FETCH_ASSOC);

$path_img = 'http://localhost/SocialNetwork-Fullstack-Project/classlink_app/profiles/uploads/';

    // Préparation de la requète permettant de récupérer toute les infos lié à ce profile via l'id
    $account_info_request =  $app_pdo->prepare("
        SELECT * FROM profiles
        WHERE id = :id;
    ");

    // Execution de la requète
    $account_info_request->execute([
        ":id" => $_SESSION['id']
    ]);

    // Récupération du résultat de la requète
    $result = $account_info_request->fetch(PDO::FETCH_ASSOC);

    // Variables contenant les informations du compte, suivi d'une condition qui permettra d'afficher "non renseigné" si la variable contient "null"
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
        $age = 'Non renseigné';
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

$group_count_request = $app_pdo->prepare("
    SELECT COUNT(group_id) AS 'number_of_groups' FROM profiles
    LEFT JOIN group_members ON profile_id = profiles.id
    WHERE profile_id = :id
");

$group_count_request->execute([
    ':id' => $_SESSION['id']
]);

$group_count_result = $group_count_request->fetch(PDO::FETCH_ASSOC);

$numbers_of_groups = $group_count_result['number_of_groups'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../assets/js/script.js"></script>
    <link rel="stylesheet" href="../../assets/css/group_dashboard.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <title><?php echo $title?></title>
</head>
<body>
<section class="header">
        <a class="logo" href="">
            <img src="../../assets/img/white_logo.svg" alt="logo">
        </a>
        <div class="input-box">
            <input id="input" type="text" placeholder="Recherche...">
            <span class="search">
                <i class="uil uil-search search-icon"></i>
                <ul class="dropdown" id="dropdown"></ul>
            </span>
            <i class="uil uil-times close-icon"></i>
        </div>
        <a class="profile-icon-header" href="">
            <img src="../../assets/img/ellipse.svg" alt="profile-icon">
        </a>
        <a class="tv-icon" href="">
            <img src="../../assets/img/tv-header.svg" alt="tv-icon">
        </a>
        <a class="notifications" href="">
            <img src="../../assets/img/header-bell.svg" alt="bell-icon">
        </a>
        <a class="messages-icon" href="">
            <img src="../../assets/img/messages-icon.svg" alt="messages-icon">
        </a>
    </section>

    <main>
    <div class='dashboard-leftside'>
        <div class="informations">
            <div class="top">
                <div class="img"><img src="../../assets/img/default_pp.jpg" alt=""></div>
                <div class="name">
                    <p><?php echo $firstname . ' ' . $lastname; ?></p>
                </div>
                <div class="separator"></div>
            </div>
            <div class="mid">
                <div class="personnal-info">
                    <div><p>Anniversaire <span>: <?php echo $birth_date; ?></span></p></div>
                    <div><p>Genre <span>: <?php echo $gender; ?></span></p></div>
                    <div><p>E-mail <span>: <?php echo $mail; ?></span></p></div>
                </div>
            </div>
            <div class="bottom">
                <div class="btn2"><a href="../profiles/change_settings.php"><button>Modifier</button></a></div> <!-- Rajouter le lien vers modifier profil--> 
            </div>
        </div>
        <div class='relations-groups-pages'>
            <div>
                <div class='text-number'>
                    <div class='txt'><p>Relations</p></div>
                    <div><p><?php echo $numbers_of_relations; ?></p></div>
                </div>
                <div class='separator2'></div>
            </div>
            <div>
                <div class='text-number'>
                    <div class='txt'><p>Groupes</p></div>
                    <div><p><?= $numbers_of_groups ?></p></div>
                </div>
                <div class='separator2'></div>
            </div>
            <div>
                <div class='text-number'>
                    <div class='txt'><p>Pages</p></div>
                    <div><p><?php echo $numbers_of_pages; ?></p></div>
                </div>
            </div>
            <div class="btn">
                <a href="../connections/logout.php"><button>Se déconnecter</button></a>
            </div>
        </div>
    </div>
    <div class="container-right">
        <div class="joined-groups">
            <div class="header">
                <div class="header-content">
                    <div class="title"><p><?php echo $title; ?></p></div>
                    <div><p><?php echo count($result2); ?></p></div>
                </div>
            </div>
            <div class="main">
                <?php foreach ($result2 as $group) { ?>
                    <?php
                    // Requête pour obtenir le nombre de membres inscrits
                    $memberCountQuery = $app_pdo->prepare('
                        SELECT COUNT(*) as member_count
                        FROM group_members
                        WHERE group_id = :group_id;
                    ');
                    $memberCountQuery->execute([
                        ':group_id' => $group['id']
                    ]);
                    $memberCountResult = $memberCountQuery->fetch(PDO::FETCH_ASSOC);
                    $memberCount = $memberCountResult['member_count'];
                    ?>
                    <div class="card-banner">
                        <div class="banner"><img src="../../assets/img/default_banner.jpg" alt=""></div>
                        <div class="title"><p><?php echo $group['name']; ?></p></div>
                        <div class="info">
                            <div class="info-grp"><p><?php echo $memberCount; ?> membre<?php echo ($memberCount > 1) ? 's' : ''; ?> - <?php echo $numbers_of_publications; ?> publication<?php echo ($numbers_of_publications > 1) ? 's' : ''; ?></p></div>
                            <div class="link"><a href="../groups/group.php">Voir le groupe</a></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="create"><a href="../groups/create_group.php"><button>Créer un groupe</button></a></div>
        </div>
        <div class="suggest-groups">
            <div class="header">
                <div class="header-content">
                    <div class="title"><p>Suggestion de groupes</p></div>
                    <div><p><?php echo count($result3); ?></p></div>
                </div>
            </div>
            <div class="main">
                <?php foreach ($result3 as $group) { ?>
                    <?php
                    // Requête pour obtenir le nombre de membres inscrits
                    $memberCountQuery = $app_pdo->prepare('
                        SELECT COUNT(*) as member_count
                        FROM group_members
                        WHERE group_id = :group_id;
                    ');
                    $memberCountQuery->execute([
                        ':group_id' => $group['id']
                    ]);
                    $memberCountResult = $memberCountQuery->fetch(PDO::FETCH_ASSOC);
                    $memberCount = $memberCountResult['member_count'];
                    ?>
                    <div class="card-banner">
                        <div class="banner"><img src="../../assets/img/default_banner.jpg" alt=""></div>
                        <div class="title"><p><?php echo $group['name']; ?></p></div>
                        <div class="info">
                            <div class="info-grp"><p><?php echo $memberCount; ?> membre<?php echo ($memberCount > 1) ? 's' : ''; ?> - <?php echo $numbers_of_publications; ?> publication<?php echo ($numbers_of_publications > 1) ? 's' : ''; ?></p></div>
                            <div class="link"><a href="../groups/group.php">Voir le groupe</a></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>


</body>
</html>
