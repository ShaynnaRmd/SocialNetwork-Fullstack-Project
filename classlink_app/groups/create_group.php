<?php
require '../inc/pdo.php';
require '../inc/functions/token_functions.php';

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
            ':name_group' => $name_group,
            ':description' => $description,
            ':status' => $status,
            ':banner_image' => $banner_image,
            ':creator_profile_id' => $creator_profile_id
        ]);
        
        $select_name_create_group = $app_pdo->prepare('
        SELECT id FROM groups_table
        WHERE name = :name_group
        ');
        $select_name_create_group->execute([
            ':name_group'=>$name_group
        ]);
        $ID_group = $select_name_create_group ->fetch(PDO::FETCH_ASSOC);
        $adding_member = $app_pdo->prepare('
        INSERT INTO group_members (profile_id,group_id)
        VALUES (:profile_id,:group_id);
        ');
        $adding_member->execute([
            ':profile_id' => $_SESSION['id'],
            ':group_id'=>$ID_group['id']
        ]);
        echo 'Bien créer';
        }
    else{
        echo 'Ce nom de groupe existe déjà';
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
    <title>Groupes</title>
</head>
<body>
    <?php include '../inc/tpl/header.php'; ?>
    <main>
        <div class="left-side">
            <div class="informations">
                <div class="top">
                    <div class="img"><img src="../../assets/img/default_pp.jpg" alt=""></div>
                    <div class="name">
                        <p><?php echo  $first_name." ".$last_name ?></p>
                    </div>
                    <div class="separator"></div>
                </div>
                <div class="mid">
                    <div class="personnal-info">
                        <div><p>Anniversaire <span>: <?php echo $birth_date ?></span></p></div>
                        <div><p>Genre <span>: <?php echo $gender ?></span></p></div>
                        <div><p>E-mail <span>: <?php echo $mail ?></span></p></div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="btn2"><a href=""><button>Modifier</button></a></div> <!-- Rajouter le lien vers modifier profil--> 
                </div>
            </div>
            <div class="btn">
                <a href="../connections/logout.php"><button>Déconnexion</button></a>
            </div>
        </div>
        <div class="create">
            <div class="header">
                <div><h2>Créer un groupe</h2></div>
            </div>
            <div class="main">
                <form method="POST">
                    <div>
                        <label for="name">Nom du groupe</label>
                        <input id="name" type="text" name="name">
                    </div>
                    <div>
                        <label for="subject">Sujet du groupe</label>
                        <input id="subject" type="text" name = "description">
                    </div>
                    <div>
                        <label for="statut">Statut du groupe</label>
                        <select name="status" id="status">
                            <option value="Public">Publique</option>
                            <option value="private">Privé</option>
                        </select>
                    </div>
                    <div>
                        <label for="image">Image du groupe</label>
                        <input type="file" id="fileInput" name = "banner_image" class="custom-file-input">
                        <label for="fileInput" class="custom-file-label">Choisir un fichier</label>
                    <div class="submit"><input class="input" type="submit" value = "Créer un groupe"></div>
                    </div>
                </form>
                <div class="planet"><img src="../../assets/img/create_groups_planet.svg" alt=""></div>
            </div>
        </div>
    </main>
    <script src="../../assets/js/notifications.js"></script>
</body>
</html>