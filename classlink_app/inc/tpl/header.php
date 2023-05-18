<?php
require '../pdo.php';
session_start();
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
if($result){
    $pp_image = $result['pp_image']
}

?>
    
    <header>
        <div class='logo'><img src= "<?= $dirimg . '/white_logo.svg' ?>"alt=""></div>
        <div class='nav'>
            <div><img src="<?= $dirimg . '/search.svg' ?>" alt=""></div>
            <div><img src="<?= $uploadpath" class='pp' alt=""></div>
            <div><img src="<?= $dirimg . '/live.svg' ?>" alt=""></div>
        </div>
        <div class='left-side'>
            <div><img src="<?= $dirimg . '/bell.svg' ?>" alt=""></div>
            <div><img src="<?= $dirimg . '/messages.svg' ?>" alt=""></div>
        </div>
    </header>