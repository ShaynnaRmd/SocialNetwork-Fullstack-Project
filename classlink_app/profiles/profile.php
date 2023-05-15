<?php
   require '../../classlink_app/inc/pdo_authentification.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json,true);
    
    $birth_date = $data ['birth_date'];
    $first_name = $data["first_name"];
    $last_name = $data['last_name'];
    $mail = $data["mail"];
    $gender = $data["gender"];

    $requete_recuperation_profile = $auth_pdo->prepare("
    INSERT INTO profiles (birth_date,first_name,last_name,mail,gender)
    VALUES (:birth_date, :first_name, :last_name, :mail, :gender)
    ");

    $requete_recuperation_profile->execute([
      "birth_date"=> $birth_date,
      ":first_name"=> $first_name,
      ":last_name"=> $last_name,
      ":mail"=> $mail,
      ":gender"=> $gender
    ]);

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Profil</title>
    </head>
    <body>
         <p><?php $birth_date?></p>
         <p><?php $first_name?></p>
         <p><?php $last_name?></p>
         <p><?php $mail?></p>
         <p><?php $gender?></p>
    </body>
    </html>





