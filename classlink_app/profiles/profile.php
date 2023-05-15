<?php
   require '../../classlink_app/inc/pdo_authentification.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json,true);
    
    $username = $data["username"];
    $birth_date = $data ['birth_date'];
    $first_name = $data["first_name"];
    $last_name = $data['last_name'];
    $mail = $data["mail"];
    $gender = $data["gender"];

    $requete_recuperation_profile = $auth_pdo->prepare("
    INSERT INTO profiles (username,birth_date,first_name,last_name,mail,gender)
    VALUES (:username, :birth_date, :first_name, :last_name, :mail, :gender)
    ");

    $requete_recuperation_profile->execute([
      ":username"=> $username,
      "birth_date"=> $birth_date,
      ":first_name"=> $first_name,
      ":last_name"=> $last_name,
      ":mail"=> $mail,
      ":gender"=> $gender
    ]);
    





