<?php
   require '../../classlink_app/inc/pdo_authentification.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json,true);
    
    $username = $data["username"];
    $password = $data["password"];
    $first_name = $data["first_name"];
    $last_name = $data['last_name'];
    $mail = $data["mail"];
    $gender = $data["gender"];


