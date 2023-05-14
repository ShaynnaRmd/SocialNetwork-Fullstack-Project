<?php
require '../inc/tpl/pdo.php';

$path_img = 'http://localhost/SocialNetwork-Fullstack-Project/classlink_app/profiles/uploads/';
$img = 'IMG-645df3ad6824d9.17405105.jpg';
$username = 'yassine';
$requete = $app_pdo->prepare("
SELECT * FROM profiles WHERE last_name = :last_name
");
$requete->execute([
    ":last_name" => $username
]);
$result = $requete->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" type="text/css" href="./style.css">
    </head>
    <header>
        <h1>ClassLink</h1>
        <input type="text" placeholder="Rechercher">
    </header>
    <body>
        <div>
            <img class='banner_image' src="" alt="">
            <img class='pp_image' src="" alt="">
            <p><span></span> <span></span></p>
            <button>Modifier le profil</button>
                <div>
                    <ul>
                        <a href=""><li>Relations</li></a>
                        <a href=""><li>Groupes</li></a>
                        <a href=""><li>Pages</li></a>
                        <a href=""><li>Paramètres</li></a>
                    </ul>
                </div>
        </div>

        <div>
        <aside>
            <h2>Informations personnelles</h2>
            <ul>
                <li>Age: </li>
                <li>Genre: </li>
                <li>Email: </li>
            </ul>
        </aside> 
        <button>Se déconnecter</button>
        </div>

        <div>
            <img class='pp_image' src="" alt="">
            <textarea name="" id="" cols="30" rows="10" placeholder='Exprimez-vous...'></textarea>
        </div>
        
        <aside>
            <pre>
                Infos  Assistance  Accessibilité
                Conditions générales
                Confidentialité
                Publicité   Contacter l'équipe
                Solutions professionelles

                ClassLink Corporation 2023
            </pre>
        </aside>

        <div>
                <img src="http://localhost/SocialNetwork-Fullstack-Project/classlink_app/profiles/uploads/IMG-645df3ad6824d9.17405105.jpg" alt="">
                <p><?= $result['mail'] ?></p>
                 <?php echo "$path_img$img"; ?>
                
                <img src='<?php echo $path_img.$img?>' alt="">
        </div>

<!-- 
        <form method="post" enctype="multipart/form-data" action="upload.php">
        <input type="file" name="file">
        <input type="submit" value="Upload" name="submit"> -->
    </body>
    </html>

