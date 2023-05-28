<?php
session_start();
require './inc/pdo.php';
require './inc/functions/token_functions.php';
require '../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
    if(isset($_SESSION['token'])){
        $check = token_check($_SESSION["token"], $auth_pdo);
        if($check == 'false'){
            header('Location: ./connections/login.php');
        }
    }elseif(!isset($_SESSION['token'])){
        header('Location: ./connections/login.php');
    }
echo $_SESSION['id'];

$method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

    $path_img = 'http://localhost/SocialNetwork-Fullstack-Project/classlink_app/profiles/uploads/';
    $client = new \GuzzleHttp\Client();
    if(isset($_SESSION['id'])) {
        
    $response = $client->post('http://localhost/SocialNetwork-Fullstack-Project/classlink_app/profiles/upload.php');


        $requete = $app_pdo->prepare("
            SELECT last_name, first_name, birth_date, gender, mail, pp_image,banner_image, username FROM profiles WHERE id = :id;
        ");
        $requete->execute([
            ":id" => $_SESSION['id']
        ]);

        $result = $requete->fetch(PDO::FETCH_ASSOC);
        if($result){
            $last_name = $result['last_name'];
            if ($last_name == null) {
                $last_name = 'Non renseigné';
            }
            $first_name = $result['first_name'];
            if ($first_name == null) {
                $first_name = 'Non renseigné';
            }
            $username = $result['username'];
            $birth_date = $result['birth_date'];
        
            if ($birth_date == null) {
                $age = 'Non renseignée';
            } else {
                $current_date = new DateTime();
                $birth_date = new DateTime($birth_date);
                $diff = $current_date->diff($birth_date);
                $age = $diff->y;
            }

            $gender = $result['gender'];
            switch ($gender) {
                case 'male':
                    $gender = 'Homme';
                    break;
                case 'female':
                    $gender = 'Femme';
                    break;
                case 'other':
                    $gender =  'Autre';
                    break;
                default:
                    $gender = 'Non renseigné';
                    break;
            }
        
            $mail = $result['mail'];
            if ($mail == null) {
                $mail = 'Non renseigné';
            }
        } else {
            echo'erreur';
        }
    }

    if(isset($_SESSION['id'])) {
        $requete = $app_pdo->prepare(
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



//recup les img apres les upload
if (isset($_POST['submit']) && isset($_FILES['file'])) {
    $img_name = $_FILES['file']['name'];
    $img_size = $_FILES['file']['size'];
    $tmp_name = $_FILES['file']['tmp_name'];
    $error = $_FILES['file']['error'];
    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_ex_lc = strtolower($img_ex);

    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
    $img_upload_path = '../profiles/uploads/' . $new_img_name;

    if (move_uploaded_file($tmp_name, $img_upload_path)) {
        $add_image = $app_pdo->prepare("UPDATE test_publications SET image = :image WHERE id = :id");
        $add_image->execute([
            ":image" => $new_img_name,
            ":id" => $_SESSION['id']
        ]);


        echo 'Succès de la mise à jour de limage';
        echo $new_img_name;
    } else {
        echo 'Erreur lors du déplacement du fichier';
    }
}
// recup les publication

if(isset($_POST['publication_titre'], $_POST['publication_contenu']))
    if(!empty($_POST['publication_titre']) AND !empty($_POST['publication_contenu'])) {
        
        $publication_titre = ($_POST['publication_titre']);
        $publication_contenu = ($_POST['publication_contenu']);
       
        $requete = $app_pdo->prepare("INSERT INTO test_publications (titre, text, image, date_time_publication, profile_id)
        VALUES (?, ?, ?, NOW(), ?)");
        $requete->execute(array($publication_titre, $publication_contenu,$new_img_name, $_SESSION['id']));
        var_dump($requete);
        $message = "Votre article a bien été posté";

    } else {
        $message = 'Veuillez remplir tout les champs';
    }

    // afficher chaque publications
    if(isset($_SESSION['id'])) {
        $afficher_publications = $app_pdo->prepare("SELECT * FROM test_publications WHERE id <> ?;");
        $afficher_publications->execute(array($_SESSION['id']));

        $result_pub = $afficher_publications->fetch(PDO::FETCH_ASSOC);
        if($result_pub){
            $id_pub = $result_pub['id'];
        }
        var_dump($result_pub);

        $likes = $app_pdo->prepare("SELECT id FROM likes WHERE test_publications_id = ?");
        $likes->execute(array($id_pub));
        $likes = $likes->rowCount();
        var_dump($likes);


        $dislikes = $app_pdo->prepare("SELECT id FROM dislikes WHERE test_publications_id = ?");
        $dislikes->execute(array($id_pub));
        $dislikes = $dislikes->rowCount();

        $comment = $app_pdo->prepare('SELECT * FROM comments_publications WHERE id_publication = ?');
        $comment->execute(array($id_pub));

        if(isset($_POST['submit_commentaire'])){
            if(isset($_POST['pseudo'],$_POST['commentaire']) AND !empty($_POST['pseudo']) AND !empty($_POST['commentaire'])){
                $pseudo = $_POST['pseudo'];
                $commentaire = $_POST['commentaire'];

                if(strlen($pseudo) < 25 ) {

                    $ins = $app_pdo->prepare('INSERT INTO comments_publications(pseudo, commentaire, id_publication) VALUES (?,?,?)');
                    $ins->execute(array($pseudo, $commentaire,$id_pub));
                    
                    $c_msg = 'Votre commentaire a était poster';

                    
                }else {
                $c_msg = "Erreur : Le pseudo doit faire moins de 25 caractères";
                }


            }else{
                $c_msg = "Erreur : Tous les champs doivent être complétés";
            }
        }
        
    } else {
        $afficher_publications = $app_pdo->prepare("SELECT * FROM test_publications;");
        $afficher_publications->execute();
    }


    // if(isset($_SESSION['id'])) {

    // $sql=("SELECT * FROM relation WHERE statut = 2 and (id_demandeur = :user or id_receveur = :user)");
    // $stmt = $app_pdo->prepare($sql);
    // $stmt->execute(array(
    //     ':user' => $_SESSION['id']
    // ));
    // $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // $listefriends = array();
    // foreach($friends as $friend){
    //     if($friend['id_demandeur'] == $_SESSION['id']){
    //         $friend = $friend['id_receveur'];
            
    //     }
    //     else{
    //         $friend = $friend['id_demandeur'];
           
    //     }
    //     if(isset($friend)){
    //         $sql="SELECT * FROM test_publications WHERE profile_id = :friend";
    //         $stmt = $app_pdo->prepare($sql);
    //         $stmt->execute(array(
    //             ':friend' => $friend
    //         ));
    //         $friend = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //         var_dump($friend);
    //         // $listefriends[] = $friend;
    //         //enregistre les donnees usernames et id dans un tableau  
    //     }
        
    //     }
    // }
    // echo json_encode($listefriends);
    

    if($_SESSION['profile_status'] == 'Inactif') {
        header('Location: ./profiles/settings.php');
        exit();        
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="../assets/js/script.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <title>Classlink-Dashboard</title>
</head>
<body>
    <section class="header">
        <a class="logo" href="">
            <img src="../assets/img/white_logo.svg" alt="logo">
        </a>
        <div class="input-box">
            <input id="input" type="text" placeholder="Recherche...">
            <span class="search">
                <i class="uil uil-search search-icon"></i>
                <ul class="dropdown" id="dropdown"></ul>
            </span>
            <i class="uil uil-times close-icon"></i>
        </div>
        <a class="profile-icon-header" href="">
            <img src="../assets/img/ellipse.svg" alt="profile-icon">
        </a>
        <a class="tv-icon" href="">
            <img src="../assets/img/tv-header.svg" alt="tv-icon">
        </a>
        <a class="notifications" href="">
            <img src="../assets/img/header-bell.svg" alt="bell-icon">
        </a>
        <a class="messages-icon" href="">
            <img src="../assets/img/messages-icon.svg" alt="messages-icon">
        </a>
    </section>
    <section class="profil">
        <div class="profile-head">
            <img class="profile-pic" src="../assets/img/ellipse.svg" alt="profile-pic">
            <h3><?= $first_name.' '.$last_name?></h3>
        </div><hr>
        <div class="profile-infos">
            <p>Age: <span><?= $age ?></span></p>
            <p>Genre: <span><?= $gender ?></span></p>
            <p>Email: <span><?= $mail ?></span></p>
        </div>
        <div>
            <button class="profile-button">Modifier</button>
        </div>
    </section>
    <section class="create-post">
        <!-- <img class="post-profile-pic" src="<?= $path_img . $pp_image?>" alt="profile-icon"> -->
        <form method="POST" enctype="multipart/form-data">

            <input class="post-titre" type="text" name="publication_titre" placeholder="Titre" />

            <textarea class="post-button" name="publication_contenu" placeholder="Exprimez-vous..."></textarea>

            <input type="file" name="file">

            <input type="submit" value="Publier" name="submit">

            </form>
        
    </section>
    <section class="informations">
        <p>Relations<span>57</span></p><hr>
        <p>Groupes<span>4</span></p><hr>
        <p>Pages<span>7</span></p>
    </section>
    <section class="suggestions">
        <h3 class="suggestions-title">Suggestions</h3>
        <h4>Personnes:</h4>
        <div class="suggestion-line">
            <img src="../assets/img/empty-pp.svg" alt="profile-icon">
            <p>Prénom Nom</p>
            <button class="quick-add">+</button>
        </div>
        <div class="suggestion-line">
            <img src="../assets/img/empty-pp.svg" alt="profile-icon">
            <p>Prénom Nom</p>
            <button class="quick-add">+</button>
        </div>
        <div class="suggestion-line">
            <img src="../assets/img/empty-pp.svg" alt="profile-icon">
            <p>Prénom Nom</p>
            <button class="quick-add">+</button>
        </div>
        <div class="suggestion-line">
            <img src="../assets/img/empty-pp.svg" alt="profile-icon">
            <p>Prénom Nom</p>
            <button class="quick-add">+</button>
        </div>
        <h3 class="pages-title">Pages</h3>
        <div class="pages-container">
            <div class="item1"></div>
            <div class="item2"></div>
            <div class="item3"></div>
            <div class="item4"></div>
        </div>

    </section>
    <section class="timeline">
        <div class="post-information">
        <?php
            foreach($afficher_publications as $afp) {
        ?>
            <img class="post-profile-pic" src="<?php echo $path_img . $pp_image ?>" alt="profile-icon">
            <h3 class="post-name"><?= $first_name.' '.$last_name?></h3>
        </div>
        <p class="post-description"><?= $afp['text']?>
            <span id="dots">...</span>
            <span id="more"><?= $afp['date_time_publication']?></span>
        </p>
        <a class="read-more" onclick="readMore()" id="myBtn">Voir plus</a>
        <div>
            <img class="post-image" src="<?= $path_img.$afp['image'] ?>" alt="post">
        </div>

            <?php
                }
            ?>

             <div>
             </div><br><br>
             <div class="interactions">
                 <a class="like" href="profiles/action_dash.php?t=1&id=<?= $_SESSION['id'] ?>">J'aime (<?= $likes ?>)</a> 
                 <form method="POST">
                     <input class="comment" type="text" name="pseudo" placeholder="Votre pseudo"/><br>
                     <textarea class="comment" name="commentaire" placeholder="Votre commentaire..."></textarea><br>
                     <input type="submit" value="Commenter" name="submit_commentaire"/>
                 </form>
                 <!-- <button class="comment"><img src="../assets/img/Messenger.svg" class="comment-icon" alt="like">Commenter</button> -->
             </div>
                

             

                
    </section>
    <button class="disconnect">Se déconnecter</button> 
    <a href="./profiles/profile.php">Mon profil</a>

    <script>
        let inputBox = document.querySelector(".input-box"),
            search = document.querySelector(".search"),
            closeIcon = document.querySelector(".close-icon")

        search.addEventListener("click", () => inputBox.classList.add("open"))
        closeIcon.addEventListener("click", () => inputBox.classList.remove("open"))
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
          
          function fetchData(){
            let value = $("#input").val(); // Permet de récupérer la valeur de l'input
            console.log(value)
            if (value == '') { // if la valeur de value est null
               $('#dropdown').css('display', 'none');
            }
            $.post("index.php", 
                  {
                    'value' : value
                  },
                  function(data, status){
                      if (data != "not found") {
                        $('#dropdown').css('display', 'block');
                        $('#dropdown').html(data);
                      }
                  });
          }
          $('#input').on('input', fetchData);
          $("body").on('click', () => {
            $('#dropdown').css('display', 'none');
          });
          $('#input').on('click', fetchData);
      });
    </script>


</body>
</html>
