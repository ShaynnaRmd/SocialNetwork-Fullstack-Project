<?php
session_start();
// require '../inc/pdo.php';
// require '../../vendor/autoload.php';
// use GuzzleHttp\Client;
// use GuzzleHttp\RequestOptions;

// $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

// $path_img = 'http://localhost/SocialNetwork-Fullstack-Project/classlink_app/profiles/uploads/';

//     $requete = $app_pdo->prepare("
//     SELECT * FROM profiles WHERE id = :id
//     ");
//     $requete->execute([
//         ":id" => $_SESSION['id']
//     ]);
//     $result = $requete->fetch(PDO::FETCH_ASSOC);
//     echo var_dump($result);

//     if($result){

//     }


// if($method == 'POST') {
//     $client = new \GuzzleHttp\Client();
//    $response = $client->post('http://localhost/SocialNetwork-Fullstack-Project/classlink_app/profiles/upload.php', [
//       'body' => $json
//   ]);
//   $data = json_decode($response->getBody(), true);
//    //  $requete = $app_pdo->prepare("
//    //  SELECT * FROM profiles WHERE id = :id
//    //  ");
//    //  $requete->execute([
//    //      ":id" => $_SESSION['id']
//    //  ]);
//    //  $result = $requete->fetch(PDO::FETCH_ASSOC);
//    //  if(isset($result)){
//    //      $requete = $app_pdo->prepare("
//    //      UPDATE profiles SET pp_image = :pp_image WHERE id = :id
//    //  ");
//    //  $requete->execute([
//    //      ":pp_image" => $pp_image,
//    //      ':id' => $id
//    //  ]);
//    //  }
// } 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/css/profile.css" rel="stylesheet"></link>
    <title>Document</title>
</head>
<body>
    <header>
    </header>
    <div class='header-profile'>
        <div class='banner'>
            <img src="../../assets/img/default-banner.png" alt="banner">
            <div class="btn"><button>Modifier le profil</button></div>
            <div class="name"><p>Yassine Hamil</p></div>
        </div>
        <div class="pp"><img src="../../assets/img/default_pp.jpg" alt=""></div>
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
            <div><p>Age <span>: 20</span></p></div>
            <div><p>Genre <span>: Homme</span></p></div>
            <div><p>E-mail<span>: test_mail@gmail.com</span></p></div>
        </div>
    </div>
    <div class="btn2"><a href=""><button>Se déconnecter</button></a></div>
    <div class="create-post" id='create-post'>
        <div class="pp-post"><img src="../../assets/img/default_pp.jpg" alt=""></div>
        <div class="fake-input"><p>Exprimez-vous...</p></div>
    </div>
    <div class="post">
        <div class="top-post">
            <div class="post-pp"><img src="../../assets/img/default_pp.jpg" alt=""></div>
            <div class="post-name"><p>Djedje Gboble</p></div>
            <div class="post-text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p></div>
            <div class="post-date"><p>Le 27/06/2023, à 22:47</p></div>
            <div class="plus"><p>Afficher plus...</p></div>
        </div>
        <div class="img-post"><img src="../../assets/img/default-banner.png" alt=""></div>
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
</body>
</html>

