<?php
require '../inc/pdo.php';
session_start();

$title = "Créer une groupe";

if(!isset($_SESSION["token"]) &&  !isset($_SESSION['id'])){
    header('Location: ../connections/login.php');
    exit();
}

$id = $_SESSION['id'];

$recuperation_data_profiles = $app_pdo -> prepare('
    SELECT last_name, first_name, birth_date, gender, mail, pp_image FROM profiles
    WHERE id = :id;
');
$recuperation_data_profiles->execute([
    ":id" => $id
]);

$profile_data = $recuperation_data_profiles ->fetch(PDO::FETCH_ASSOC);

if($profile_data){
    $last_name = $profile_data['last_name'];
    $first_name = $profile_data['first_name'];
    $birth_date = $profile_data['birth_date'];
    $gender = $profile_data['gender'];
    $mail = $profile_data['mail'];
    $pp_image = $profile_data['pp_image'];
    } else {
        echo'erreur';
    }

$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

if($method == 'POST'){
    $name_group = filter_input(INPUT_POST,"name");
    $description = filter_input(INPUT_POST,"description");
    $status = filter_input(INPUT_POST,"status");
    $banner_image = filter_input(INPUT_POST,"banner_image");

    $verify_existing_group_request = $app_pdo->prepare("
        SELECT * FROM groups_table 
        WHERE name = :name;
    ");
    $verify_existing_group_request->execute([
        ":name" => $name_group
    ]);

    $verify_existing_group = $verify_existing_group_request ->fetch(PDO::FETCH_ASSOC);

    if(!$verify_existing_group){
        if(isset($_SESSION['id'])){
            $request_groups_creator_profile_id = $app_pdo -> prepare('
            SELECT * FROM profiles WHERE id = :id
            ');
            $request_groups_creator_profile_id->execute([
            ':id' => $_SESSION['id']
            ]);
            }
       
        $creator_profile_id = $_SESSION['id'];

        $create_group_request = $app_pdo -> prepare('
        INSERT INTO groups_table (name,description, status, banner_image,creator_profile_id)
        VALUES (:name_group, :description, :status, :banner_image,:creator_profile_id);
        ');
        $create_group_request->execute([
            ':creator_profile_id' => $creator_profile_id,
            ':name_group' => $name_group,
            ':description' => $description,
            ':status' => $status,
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
        <label for="name">Nom du groupe</label>
        <input type="text" name = "name" placeholder = "Nom du groupe">
        <label for="description">Sujet du groupe</label>
        <textarea name="description" id="description" cols="30" rows="10" placeholder = "Sujet du groupe ..."></textarea>
        <label for="status">Statut du groupe</label>
        <select name="status" id="status">
            <option value="public" name = "public">Public</option>
            <option value="prive" name = "prive">Privé</option>
        </select>
        <label for="banner_image">Image de groupe</label>
        <input type="file" value = "Choisissez un fichier" name = "banner_image">
        <input type="submit" value = "Créer un groupe" >
    </form>
    <img src="<?php echo $pp_image ?>" alt="">
    <p><?php echo  $first_name." ".$last_name ?></p>
    <p><?php echo $birth_date ?></p>
    <p><?php echo $gender ?></p>
    <p><?php echo $mail ?></p>
    <a href="../connections/logout.php"><button>Déconnexion</button></a>
</body>
</html>