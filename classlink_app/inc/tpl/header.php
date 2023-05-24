<?php
if(isset($_SESSION['token'])){
    $check = token_check($_SESSION["token"], $auth_pdo);
    if($check == 'false'){
        header('Location: ./connections/login.php');
    }
}elseif(!isset($_SESSION['token'])){
    header('Location: ./connections/login.php');
}

$requete = $app_pdo->prepare("
SELECT pp_image FROM profiles WHERE id = :id;
");
$requete->execute([
    ":id" => $_SESSION['id']
]);
$result = $requete->fetch(PDO::FETCH_ASSOC);
$path_img = 'http://localhost/SocialNetwork-Fullstack-Project/classlink_app/profiles/uploads/';
$dirimg = 'http://localhost/SocialNetwork-Fullstack-Project/assets/img/';

if($result){
    $pp_image = $result['pp_image'];
}else{
    $pp_image = 'default_pp.jpg';
}

?>
    
    <header>
        <div class='header-logo'><img src= "<?= $dirimg . 'white_logo.svg' ?>"alt=""></div>
        <div class='header-nav'>
            <div><img src="<?= $dirimg . 'search.svg' ?>" alt=""></div>
            <div><img src="<?= $path_img . $pp_image ?>" class='header-pp' alt=""></div>
            <div><img src="<?= $dirimg . 'live.svg' ?>" alt=""></div>
        </div>
        <div class='header-left-side'>
            <div><img id='notification' src="<?= $dirimg . 'bell.svg' ?>" alt=""></div>
            <div><img src="<?= $dirimg . 'messages.svg' ?>" alt=""></div>
        </div>
    </header>
    <div id='overlay-notification' class="overlay-notification">
        <div class="notification-content">
            <div class="top-overlay">
                <div class="title"><h2>Notifications</h2></div>
                <div id='cross' class="cross"><img src="<?= $dirimg . 'cross.svg' ?>" alt=""></div>
            </div>
            <div class="notification-list">
                <div class="notif-container">
                    <div class="img"><img src="<?= $dirimg . 'bell_purple.svg' ?>" alt=""></div>
                    <div><p>Yassine à publié un nouveau post</p></div>
                </div>
                <div class="notif-container">
                    <div class="img"><img src="<?= $dirimg . 'bell_purple.svg' ?>" alt=""></div>
                    <div><p>Yassine à publié un nouveau post</p></div>
                </div>
                <div class="notif-container">
                    <div class="img"><img src="<?= $dirimg . 'bell_purple.svg' ?>" alt=""></div>
                    <div><p>Yassine à publié un nouveau post</p></div>
                </div>
                <div class="notif-container">
                    <div class="img"><img src="<?= $dirimg . 'bell_purple.svg' ?>" alt=""></div>
                    <div><p>Yassine à publié un nouveau post</p></div>
                </div>
            </div>
        </div>
    </div>