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

$group_ID = $_GET['id'];
$id = $_SESSION['id'];
$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
if($method == 'POST'){
    $add = filter_input(INPUT_POST,"add");
    $group_ID = $_GET['id'];
    $verify_member = $app_pdo -> prepare('
        SELECT * FROM group_members WHERE group_id = :group_id 
        AND profile_id = :profile_id;
    ');
    $verify_member->execute([
        ':profile_id'=>$_SESSION['id'],
        ':group_id'=>$id
    ]);
    $verify = $verify_member->fetch(PDO::FETCH_ASSOC);
    if(!$verify){
            
        $add_member_query = $app_pdo->prepare('
        INSERT INTO group_members (group_id, profile_id)
        VALUES (:group_id, :profile_id);');
        $add_member_query->execute([
            ':group_id' => $group_ID,
            ':profile_id' => $_SESSION['id']
        ]);
        echo 'Vous avez rejoint le groupe.';
    }
    else{
        echo 'Vous êtes déjà dans le groupe.';
        }
}

if(isset($_SESSION['id'])){    
    
    $request_page_data = $app_pdo->prepare("
    SELECT name, banner_image, description,creator_profile_id,status
    FROM groups_table
    WHERE id = :id ;
    ");
    $request_page_data->execute ([
        ":id" => $group_ID
    ]);

    $result = $request_page_data->fetch(PDO::FETCH_ASSOC);
    if($result){
        $name = $result['name'];
        $banner_image = $result['banner_image'];
        $description = $result['description'];
        $creator_profile_id = $result['creator_profile_id'];
        $statut = $result['status'];

        $request_creator_data = $app_pdo->prepare('
        SELECT last_name, first_name
        FROM profiles
        WHERE id = :creator_profile;
        ');
        $request_creator_data->execute([
            ":creator_profile" => $creator_profile_id
        ]);
        $result2 = $request_creator_data->fetch(PDO::FETCH_ASSOC);
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
    <p>Statut : <?php echo $statut ?></p>
    <p>Créer par : <?php echo $first_name ." ". $last_name  ?></p>
    <p>Abonné : </p>
    <form method = 'POST'>
        <input type="submit" value = "Rejoindre" name = "add" >
    </form>
</body>
</html>
