<?php
session_start();
require '../inc/pdo.php'; 
require '../inc/functions/token_functions.php';
$method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

if(isset($_SESSION['token'])){
    $check = token_check($_SESSION["token"], $auth_pdo);
    if($check == 'false'){
        header('Location: ./connections/login.php');
    }
}elseif(!isset($_SESSION['token'])){
    header('Location: ./connections/login.php');
}

$verify_existing_page_request = $app_pdo->prepare("
            SELECT * FROM pages 
            WHERE id = :page_id;
        ");
        $verify_existing_page_request->execute([
            ":page_id" => $_SESSION['page_id']
        ]);

$verify_existing_pages = $verify_existing_page_request ->fetch(PDO::FETCH_ASSOC);

$default_name = $verify_existing_pages['name'];
$default_description=$verify_existing_pages['description'];
$default_banner_image=$verify_existing_pages['banner_image'];

if($method == 'POST'){
    $name_page = filter_input(INPUT_POST,"name_page");
    $description = filter_input(INPUT_POST,"description");
    $banner_image = filter_input(INPUT_POST,"banner_image");
    
    if(!$name_page){
        $name_page = $default_name;
    }

    if(!$description){
        $description = $default_description;
    }


    if(!$banner_image){
        $banner_image = $default_banner_image;
    }

    if($name_page != $default_name){
        $verify_existing_page_request = $app_pdo->prepare("
            SELECT * FROM pages 
            WHERE name = :name_page;
        ");
        $verify_existing_page_request->execute([
            ":name_page" => $name_page
        ]);

        $verify_existing_pages = $verify_existing_page_request ->fetch(PDO::FETCH_ASSOC);
        if($verify_existing_pages){
            $error = true;
        }elseif(!$verify_existing_pages){
            $modify_page_request = $app_pdo -> prepare('
            UPDATE pages
            SET name = :name_page, description = :description, banner_image = :banner_image
            WHERE id = :page_id
            ');
            $modify_page_request->execute([
                ':name_page' => $name_page,
                ':description' => $description,
                ':banner_image' => $banner_image,
                ':page_id' => $_SESSION['page_id']
            ]);  
            $create = true;
        }
    }elseif($name_page == $default_name && ($description != $default_description || $banner_image != $default_banner_image)){
        $modify_page_request = $app_pdo -> prepare('
        UPDATE pages
        SET name = :name_page, description = :description, banner_image = :banner_image
        WHERE id = :page_id
        ');
        $modify_page_request->execute([
            ':name_page' => $name_page,
            ':description' => $description,
            ':banner_image' => $banner_image,
            ':page_id' => $_SESSION['page_id']

        ]);       
        $create = true;
    }elseif ($name_page == $default_name && $description == $default_description && $banner_image == $default_banner_image){
        $empty = true;
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/create_group.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <title>Modifier une page</title>
</head>
<body>
    <?php include '../inc/tpl/header.php'; ?>
    <main>
        <div class="create">
            <div class="header">
                <div><h2>Modifier la page</h2></div>
            </div>
            <div class="main">
                <form method="POST">
                    <div>
                        <label for="name_page">Nom de la page</label>
                        <input id="name" type="text" name = "name_page">
                    </div>
                    <div>
                        <label for="description">Sujet de la page</label>
                        <input id="description" type="text" name = "description">
                    </div>
                    <div>
                        <label for="image">Bannière de la page</label>
                        <input type="file" id="fileInput" name = "banner_image" class="custom-file-input">
                        <label for="fileInput" class="custom-file-label">Choisir un fichier</label>
                        <div class="submit"><input class="input" type="submit" value = "Modifier la page"></div>
                        <?php if(isset($create)) : ?>
                            <p>Page bien modifiée.</p>
                        <?php elseif (isset($error)) : ?>
                            <p>Ce nom de page est déjà utilisé. Veuillez réessayer.</p>
                        <?php elseif (isset($empty)) : ?>
                            <p>Veuillez remplir au moins un des champs.</p>
                        <?php endif; ?>
                    </div>
                </form>
                <div class="planet"><img src="../../assets/img/create_groups_planet.svg" alt=""></div>
            </div>
        </div>
    </main>
    <script src="../../assets/js/notifications.js"></script>
</body>
</html>