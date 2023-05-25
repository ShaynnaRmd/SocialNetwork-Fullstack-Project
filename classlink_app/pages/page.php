<?php 
session_start();
require '../inc/pdo.php';

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

if(isset($_SESSION['id'])){    
    $id = 6;
    $request_page_data = $app_pdo->prepare("
    SELECT name, pp_image, banner_image, description,creator_profile_id
    FROM pages
    WHERE id = :id ;
    ");
    $request_page_data->execute ([
        ":id" => $id
    ]);

    $result = $request_page_data->fetch(PDO::FETCH_ASSOC);
    if($result){
        $name = $result['name'];
        $pp_image = $result['pp_image'];
        $banner_image = $result['banner_image'];
        $description = $result['description'];
        $creator_profile_id = $result['creator_profile_id'];

        $request_creator_data = $app_pdo->prepare('
        SELECT last_name, first_name
        FROM profiles
        WHERE id = :creator_profile;
        ');
        $request_creator_data->execute([
            ":creator_profile" => $creator_profile_id
        ]);
        $last_name = $result2 ['last_name'];
        $first_name = $result2['first_name'];
    }else {
        echo 'error';
    }

}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2><?php echo $name ?></h2>
    <h3>A propos</h3>
    <p><?php echo $description ?></p>
    <p>Créer par : <?php echo $first_name ." ". $last_name  ?></p>
    <p>Abonné : </p>

</body>
</html>