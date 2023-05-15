<?php
require '../inc/pdo.php';

$method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

$path_img = 'http://localhost/SocialNetwork-Fullstack-Project/classlink_app/profiles/uploads/';


if($method == 'POST') {
   $response = $client->post('http://localhost/SocialNetwork-Fullstack-Project/classlink_app/profiles/upload.php', [
      'body' => $json
  ]);
  $data = json_decode($response->getBody(), true);
   //  $requete = $app_pdo->prepare("
   //  SELECT * FROM profiles WHERE id = :id
   //  ");
   //  $requete->execute([
   //      ":id" => $_SESSION['id']
   //  ]);
   //  $result = $requete->fetch(PDO::FETCH_ASSOC);
   //  if(isset($result)){
   //      $requete = $app_pdo->prepare("
   //      UPDATE profiles SET pp_image = :pp_image WHERE id = :id
   //  ");
   //  $requete->execute([
   //      ":pp_image" => $pp_image,
   //      ':id' => $id
   //  ]);
   //  }
} 


?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
         <form method="POST" enctype="multipart/form-data" action="upload.php">
        <input type="file" name="file">
        <input type="submit" value="Upload" name="submit">
        </form>              
        </div>

    </body>
    </html>

