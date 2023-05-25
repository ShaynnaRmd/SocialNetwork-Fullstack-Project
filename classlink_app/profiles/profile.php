<?php
session_start();
require '../inc/pdo.php';
require '../inc/functions/token_functions.php';
require '../../vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$path_img = 'http://localhost/SocialNetwork-Fullstack-Project/classlink_app/profiles/uploads/';

// $_SESSION['id'] = 78;
$client = new \GuzzleHttp\Client();
if(isset($_SESSION['id'])) {
    
  $response = $client->post('http://localhost/SocialNetwork-Fullstack-Project/classlink_app/profiles/upload.php');


    $requete = $app_pdo->prepare("
    SELECT last_name, first_name, birth_date, gender, mail, pp_image,banner_image FROM profiles WHERE id = :id;
    ");
    $requete->execute([
        ":id" => $_SESSION['id']
    ]);
    $result = $requete->fetch(PDO::FETCH_ASSOC);
    if($result){
    $last_name = $result['last_name'];
    $first_name = $result['first_name'];
    $birth_date = $result['birth_date'];
    $gender = $result['gender'];
    $mail = $result['mail'];
    $pp_image = $result['pp_image'];
    $banner_image = $result['banner_image'];
    } else {
        echo'erreur';
    }
}
if(isset($_SESSION['id'])) {
    $requete = $app_pdo->prepare(
    // SELECT image FROM profiles LEFT JOIN publications_profile ON profiles.id = profile_id WHERE id = :id;
    "SELECT profile_id, image, text FROM profiles LEFT JOIN publications_profile ON profiles.id = publications_profile.profile_id WHERE profiles.id = :id;
    ");
    $requete->execute([
        ":id" => $_SESSION['id']
    ]);
    $result = $requete->fetch(PDO::FETCH_ASSOC);
    if($result){
    $profile_id = $result['profile_id'];
    $text = $result['text'];
    $image = $result['image'];
    $text =  $result['text'];

    } else {
        echo'erreur publications';
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/css/profile.css" rel="stylesheet"></link>
    <link href="../../assets/css/header.css" rel="stylesheet"></link>
    <title>Document</title>
</head>
<body>
    <?php include '../inc/tpl/header.php'; ?>
    <div class='header-profile'>
        <div class='banner'  id="mabanner" style="background: url('<?= $path_img.$banner_image ?>')">>
            <!-- <img src="" alt="banner"> -->
            <div class="btn"><button>Modifier le profil</button></div>
            <div class="name"><p><?php echo $first_name.' '.$last_name?></p></div>
        </div>
        <div class="pp"><img src="<?php echo $path_img . $pp_image ?>" alt=""></div>
        <div class="link-list">
            <div class="empty"></div>
            <div><a href=""><p>Relations</p></a></div>
            <div><a href=""><p>Groupes</p></a></div>
            <div><a href=""><p>Pages</p></a></div>
            <div><a href=""><p>Paramètres</p></a></div>
        </div>
    </div>
    <div class="options-left">
        <div class="personnal">
            <div class="title"><h4>Informations personelles</h4></div>
            <div class="separator"></div>
            <div><p>Age <span>: <?php echo $birth_date ?></span></p></div>
            <div><p>Genre <span>: <?php echo $gender ?></span></p></div>
            <div><p>E-mail<span>: <?php echo $mail ?></span></p></div>
        </div>
    </div>
    <div class="btn2"><a href=""><button>Se déconnecter</button></a></div>
    <div class="create-post" id='create-post'>
        <div class="pp-post"><img src="<?php echo $path_img . $pp_image ?>" alt=""></div>
        <div class="fake-input"><p>Exprimez-vous...</p></div>
    </div>
    <div class="post">
        <div class="top-post">
            <div class="post-pp"><img src="<?php echo $path_img . $pp_image ?>" alt=""></div>
            <div class="post-name"><p>Djedje Gboble</p></div>
            <div class="post-text"><p><?php echo $text?></p></div>
            <div class="post-date"><p>Le 27/06/2023, à 22:47</p></div>
            <div class="plus"><p>Afficher plus...</p></div>
        </div>
        <div class="img-post" id="picspost" style="background-image: url('<?= $path_img.$image ?>')"></div>
        <div class="bottom-post">
            <div class="up">
                <div class="nb-like">
                    <div><img src="../../assets/img/thumbs-up.svg" alt=""></div>
                    <div><img src="../../assets/img/heart.svg" alt=""></div>
                    <div><img src="../../assets/img/smile.svg" alt=""></div>
                    <div class="nb"><p>3125</p></div>
                </div>
                <div class="nb-comments"><p>134 Commentaires</p></div>
            </div>
            <div class="down">
                <div class='left'>
                    <div><img src="../../assets/img/thumbs-up.svg" alt=""></div>
                    <div class="text"><p>J'aime</p></div>
                </div>
                <div class="right">
                    <div><img src="../../assets/img/comment.svg" alt=""></div>
                    <div class="text"><p>Commenter</p></div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>Infos    Assistance   Accessibilité  
            Conditions générales 
            Confidentalité
            Contacter l’équipe
            Solutions professionelles  
            
            ClassLink Corporation © 2023</p>
    </div>
    <!-- <div class='overlay'>
        <div class="photo_text">
            <div class="overlay_pp"><img src="../../assets/img/default_pp.jpg" alt="Profile Picture"></div>
            <textarea name="message" id="" placeholder="Exprimez vous...">
            </textarea>
        </div>
        <div class='separator'></div>
        <div class='send'>
            <div class="upload"><input type="file"></div>
            <div class="post"><button>Poster</button></div>
        </div>
    </div> -->
    <script src="../../assets/js/profile.js"></script>
    <script src="../../assets/js/notifications.js"></script>
</body>
</html>

