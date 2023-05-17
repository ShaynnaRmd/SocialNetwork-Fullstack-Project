<?php
require '../inc/pdo.php';
session_start();

$title = "Créer une page";



if(!isset($_SESSION["token"]) &&  !isset($_SESSION['id'])){
    header('Location: ../connections/login.php');
    exit();
}
echo $_SESSION['id'];

$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

if($method == 'POST'){
    $name_page = filter_input(INPUT_POST,"name_page");
    $description = filter_input(INPUT_POST,"description");
    $pp_image = filter_input(INPUT_POST,"pp_image");
    $banner_image = filter_input(INPUT_POST,"banner_image");

    $verify_existing_page_request = $app_pdo->prepare("
        SELECT * FROM pages 
        WHERE name = :name_page;
    ");
    $verify_existing_page_request->execute([
        ":name_page" => $name_page
    ]);

    $verify_existing_pages = $verify_existing_page_request ->fetch(PDO::FETCH_ASSOC);

    if(!$verify_existing_pages){
        if(isset($_SESSION['id'])){
            $request_pages_creator_profile_id = $app_pdo -> prepare('
            SELECT * FROM profiles WHERE id = :id
            ');
            $request_pages_creator_profile_id->execute([
            ':id' => $_SESSION['id']
            ]);
            }
       
        $creator_profile_id = $_SESSION['id'];
        $create_page_request = $app_pdo -> prepare('
        INSERT INTO pages (name,description, pp_image, banner_image,creator_profile_id)
        VALUES (:name_page, :description, :pp_image, :banner_image,:creator_profile_id);
        ');
        $create_page_request->execute([
            ':creator_profile_id' => $creator_profile_id,
            ':name_page' => $name_page,
            ':description' => $description,
            ':pp_image' => $pp_image,
            ':banner_image' => $banner_image
        ]);
        echo 'Bien créer';
        }
        else{
            echo 'Ce nom de page existe déjà';
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
</head>
<body>
    <h1><?= $title ?></h1>
    <form method = "POST">
        <label for = "name_page"></label>
        <input type="text" name = "name_page" placeholder = "Nom de la page">
        <label for = "description"></label>
        <textarea name="description" id="description" placeholder="Description brève de la page..." cols="30" rows="5" required></textarea>
        <label for="pp_image"></label>
        <input type="file" name = "pp_image" placeholder = "Image de profil">
        <label for="banner_image"></label>
        <input type="file" name = "banner_image" value = "Changer un fichier">
        <input type="submit" value = "Créer la page">
    </form>
</body>
</html>