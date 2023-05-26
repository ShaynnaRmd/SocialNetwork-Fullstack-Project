<?php
    session_start();
    require './classlink_app/inc/pdo.php';
    require './classlink_app/inc/functions/token_functions.php';
    require './vendor/autoload.php';
    use GuzzleHttp\Client;
    use GuzzleHttp\RequestOptions;
    if(isset($_SESSION['token'])){
        $check = token_check($_SESSION["token"], $auth_pdo);
        if($check == 'false'){
            header('Location: ./connections/login.php');
            exit();
        } elseif($_SESSION['profile_status'] == 'Inactif') {
            header('Location: ./settings.php');
            exit();        
        }
    }elseif(!isset($_SESSION['token'])){
        header('Location: ./connections/login.php');
        exit();
    }

    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

    // $path_img = 'http://localhost:8888/SocialNetwork-Fullstack-Project/classlink_app/profiles/uploads/';
    $path_img = 'http://localhost/SocialNetwork-Fullstack-Project/classlink_app/profiles/uploads/';
    // $_SESSION['id'] = 78;
    $client = new \GuzzleHttp\Client();
    if(isset($_SESSION['id'])) {
        
    //   $response = $client->post('http://localhost:8888/SocialNetwork-Fullstack-Project/classlink_app/profiles/upload.php');
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
//recup les img apres les upload
if (isset($_POST['submit']) && isset($_FILES['file'])) {
    $img_name = $_FILES['file']['name'];
    $img_size = $_FILES['file']['size'];
    $tmp_name = $_FILES['file']['tmp_name'];
    $error = $_FILES['file']['error'];
    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_ex_lc = strtolower($img_ex);

    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
    $img_upload_path = 'uploads/' . $new_img_name;

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
        // var_dump($requete);
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
            // var_dump($result);
        }
        
        $likes = $app_pdo->prepare("SELECT id FROM likes WHERE test_publications_id = ?");
        $likes->execute(array($id_pub));
        $likes = $likes->rowCount();
        // var_dump($likes);


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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./assets/js/script.js"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="style2.css">
    <title>Document</title>
</head>
<body>
    <!-- <section class="header">
        <a class="logo" href="">
            <img src="../../assets/img/white_logo.svg" alt="logo">
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
            <img src="../../assets/img/ellipse.svg" alt="profile-icon">
        </a>
        <a class="tv-icon" href="">
            <img src="../../assets/img/tv-header.svg" alt="tv-icon">
        </a>
        <a class="notifications" href="">
            <img src="../../assets/img/header-bell.svg" alt="bell-icon">
        </a>
        <a class="messages-icon" href="">
            <img src="../../assets/img/messages-icon.svg" alt="messages-icon">
        </a>
 </section> -->
<main>
 <div class="container">
    <div class="top-container">
        <div class="banner_button">
            <div class="button">
                <div class="name"><p><?php echo $first_name.' '.$last_name?></p></div>
                <div class="pp"><img src="<?php echo $path_img . $pp_image ?>" alt=""></div>
            </div>

        </div>
        <div class="info">
            <ul>
                <a href="./membre.php"><li>Membre</li></a>
                <a href="./classlink_app/groups/create_group.php"><li>Groupes</li></a>
                <a href="./classlink_app/pages/create_page.php"><li>Pages</li></a>
                <a href="./classlink_app/profiles/settings.php"><li>Paramètres</li></a>
            </ul>
        </div>
    </div>
    <div class="mid-container">
        <div class="apropos">
            <h1>Informations personnelles</h1>
            <div class="detail">
                <p><span style="font-weight: 500;">Age: </span> <?php echo $age ?></p>
                <p><span style="font-weight: 500;">Genre : </span><?php echo $gender ?></p>
                <p><span style="font-weight: 500;">Email : </span> <?php echo $mail ?></p>
            </div>
            <div class="btn2"><a href=""><button>Se déconnecter</button></a></div>
        </div>
        <div class="fil" >
            <div class="exprimez-vous">
                <div class="profile" >
                    <img src="<?php echo $path_img . $pp_image ?>" alt="">
                </div>
                <input type="text" name="" id="" placeholder="Exprimez-vous">
            </div>
            <?php if(isset($message)) { echo $message; } ?>
            <div class="filpost" id="fil"> 
            <?php
                foreach($afficher_publications as $afp) 
            ?>
                <div class='post'>
                    <div class='people'>
                        <div class='profile' >
                            <img src='<?php echo $path_img . $pp_image ?>' alt=''>
                        </div>
                        <p>Lucas</p>
                    </div>
                    <p><?= $afp['text'] ?></p>
                    <img src='https://www.slate.fr/sites/default/files/photos/gif11_0.gif' alt=''>
                    <div class='reaction'><p>like</p><p>commentaire</p></div>
                </div>    
            </div>
        </div>
        <div class="suggestion">
            <p>Infos    Assistance   Accessibilité  
                Conditions générales 
                Confidentalité
                Contacter l’équipe
                Solutions professionelles  
                
                ClassLink Corporation © 2023</p>
        </div>
     </div>
 </div>
</main>
 <script>
    let inputBox = document.querySelector(".input-box"),
        search = document.querySelector(".search"),
        closeIcon = document.querySelector(".close-icon")

    search.addEventListener("click", () => inputBox.classList.add("open"))
    closeIcon.addEventListener("click", () => inputBox.classList.remove("open"))
</script>
</body>
</html>