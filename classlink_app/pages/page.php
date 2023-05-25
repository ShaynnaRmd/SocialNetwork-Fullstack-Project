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

    $page_id = $_GET['id'];
    $_SESSION['page_id'] = $page_id; 
    $request_page_data = $app_pdo->prepare("
    SELECT name, banner_image, description,creator_profile_id
    FROM pages
    WHERE id = :id ;
    ");
    $request_page_data->execute ([
        ":id" => $page_id
    ]);

    $result = $request_page_data->fetch(PDO::FETCH_ASSOC);

    if($result){
        $name = $result['name'];
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

        $result2 = $request_creator_data->fetch(PDO::FETCH_ASSOC);
        $last_name = $result2['last_name'];
        $first_name = $result2['first_name'];

        $check_admin = $app_pdo->prepare('
        SELECT admin FROM subscribers_page WHERE profile_id = :id
        AND page_id = :page_id
        ');

        $check_admin->execute([
            ":id" => $_SESSION['id'],
            ":page_id" => $page_id
        ]);

        $check_admin_result=$check_admin->fetch(PDO::FETCH_ASSOC);
        if(isset($check_admin_result['admin'])){
            $statut = $check_admin_result['admin'];
        }elseif(!isset($check_admin_result['admin'])){
            $statut = 'visitor';
        }
    }else {
        echo 'error';
    }

    $display_subscribers_request = $app_pdo->prepare('
    SELECT profiles.id, last_name, first_name, admin
    FROM profiles
    LEFT JOIN subscribers_page ON profiles.id = subscribers_page.profile_id
    WHERE subscribers_page.page_id = :page_id
    ');

    $display_subscribers_request->execute([
        ":page_id" => $_SESSION['page_id']
    ]);


    if($method == 'POST'){
        $input = trim(filter_input(INPUT_POST, "input", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if($input == 'suivre'){
            $request_creator_data = $app_pdo->prepare('
            INSERT INTO subscribers_page (page_id, profile_id, admin) VALUES (:page_id, :profile_id, :admin)
        ');
        $request_creator_data->execute([
            ":page_id" => $_SESSION['page_id'],
            ":profile_id" => $_SESSION['id'],
            ":admin" => 0
        ]);
        header('Location: ' . $_SERVER['PHP_SELF'] . "?id=" . $_SESSION['page_id']);
        exit();
        }elseif ($input == 'ne plus suivre'){
        $request_creator_data = $app_pdo->prepare('
        DELETE FROM subscribers_page WHERE page_id = :page_id
        AND profile_id = :profile_id
        ');
        $request_creator_data->execute([
            ":page_id" => $_SESSION['page_id'],
            ":profile_id" => $_SESSION['id'],
        ]);
        header('Location: ' . $_SERVER['PHP_SELF'] . "?id=" . $_SESSION['page_id']);
        exit();

        }elseif ($input == 'modifier la page'){
            header('Location: ./modify_page.php');
            exit();
        }  
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page <?= $name ?></title>
</head>
<body>
    <div class="about">
        <h2><?php echo $name ?></h2>
        <h3>A propos</h3>
        <p><?php echo $description ?></p>
        <p>Créer par : <?php echo $first_name ." ". $last_name  ?></p>
        <p>Abonné : </p>
    </div>
    <div class="button">
        <?php if ($statut == 1) :?>
            <p>Vous êtes admin</p>
            <form method="POST">
             <input type="submit" name='input' value="modifier la page" >   
            </form>
        <?php elseif ($statut == 0) : ?>
            <p>Vous n'êtes pas admin</p>
            <form method="POST">
             <input type="submit" name='input' value="ne plus suivre" >   
            </form>
        <?php elseif ($statut == 'visitor') : ?>
            <p>Vous ne suivez pas la page</p>
            <form method="POST">
             <input type="submit" name='input' value='suivre' >   
            </form>
        <?php endif ?>
    </div>

    <div>
        <?php foreach ($display_subscribers_request as $subscriber){?>
        <div>
            <?= $subscriber['first_name'] . ' ' . $subscriber['last_name']; ?>
            <?php if($statut == 1){ ?>
            <?php if($subscriber['admin'] == 0){ ?>
                <div class="div-button"><button id="<?= $subscriber['id'] ?>">Ajouter comme admin</button></div>
            <?php }elseif($subscriber['admin'] == 1){ ?>
            <div class="div-button"><button id="<?= $subscriber['id'] ?>">Retirer l'admin</button></div>
        <?php }}} ?>

        </div>
    </div>

    <a href="./page_subscribers.php">Liste des abonnés</a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    const divButtons = document.getElementsByClassName("div-button");
    Array.from(divButtons).forEach(divButton => {
        divButton.addEventListener("click", () => {
            const id_btn = divButton.firstElementChild.id;
            console.log(id_btn);
            $.ajax({
                url:'script.php',
                method: 'POST',
                data: { page_id: <?php echo $_SESSION['page_id']?>, user_id: id_btn},
                success: function(response){
                location.reload();
                },
            })
            
        });
    });
    </script>
</body>
</html>