<?php
require '../inc/pdo.php';
require '../inc/functions/token_functions.php';

session_start();

$title = "Créer une page";



if(!isset($_SESSION["token"]) &&  !isset($_SESSION['id'])){
    header('Location: ../connections/login.php');
    exit();
}

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
    <link rel="stylesheet" href="../../assets/css/create_group.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <title>Pages</title>
</head>
<body>
    <?php include '../inc/tpl/header.php'; ?>
    <main>
        <div class="left-side">
            <div class="informations">
                <div class="top">
                    <div class="img"><img src="../../assets/img/default_pp.jpg" alt=""></div>
                    <div class="name">
                        <p>Prénom Nom</p>
                    </div>
                    <div class="separator"></div>
                </div>
                <div class="mid">
                    <div class="personnal-info">
                        <div><p>Anniversaire <span>: 2003-10-08</span></p></div>
                        <div><p>Genre <span>: Homme</span></p></div>
                        <div><p>E-mail <span>: test@gmail.com</span></p></div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="btn2"><a href=""><button>Modifier</button></a></div> <!-- Rajouter le lien vers modifier profil--> 
                </div>
            </div>
            <div class="btn">
                <a href=""><button>Se déconnecter</button></a> <!-- Rajouter le lien vers logout--> 
            </div>
        </div>
        <div class="create">
            <div class="header">
                <div><h2>Créer une page</h2></div>
            </div>
            <div class="main">
                <form method="POST">
                    <div>
                        <label for="name">Nom de la page</label>
                        <input id="name" type="text">
                    </div>
                    <div>
                        <label for="subject">Sujet de la page</label>
                        <input id="subject" type="text">
                    </div>
                    <div>
                        <label for="statut">Statut de la page</label>
                        <select name="statut" id="statut">
                            <option value="" selected disabled hidden>Choisir une option</option>
                            <option value="Public">Publique</option>
                            <option value="private">Privé</option>
                        </select>
                    </div>
                    <div>
                        <label for="image">Image de la page</label>
                        <input type="file" id="fileInput" class="custom-file-input">
                        <label for="fileInput" class="custom-file-label">Choisir un fichier</label>

                    </div>
                </form>
                <div class="planet"><img src="../../assets/img/create_groups_planet.svg" alt=""></div>
            </div>
            <div class="bottom-main">
                <div><button>Créer une page</button></div>
            </div>
        </div>
    </main>
    <script src="../../assets/js/notifications.js"></script>
</body>
</html>