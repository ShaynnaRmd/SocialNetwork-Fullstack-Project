<?php
   require '../../classlink_app/inc/pdo.php';

    $json2 = file_get_contents('php://input');
    $data2 = json_decode($json2,true);
    
    $birth_date = $data2 ['birth_date'];
    $first_name = $data2["first_name"];
    $last_name = $data2['last_name'];
    $mail = $data2["mail"];
    $gender = $data2["gender"];

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
   




