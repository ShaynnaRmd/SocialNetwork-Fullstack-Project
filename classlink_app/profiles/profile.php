<?php
    // Ces six informations sont nécessaires pour vous connecter à une BDD :
    // Type de moteur de BDD : mysql
    $auth_engine = "mysql";
    // Hôte : localhost
    $host = "localhost";
    // Port : 3306 (par défaut pour MySQL, avec MAMP macOS c'est 8889)
    $auth_port = 8889; // port MAMP
    $window_auth_port = 3306;
    // Nom de la BDD (facultatif) : sakila
    $auth_bdd = "classlink_authentification";
    $app_bdd = "classlink_app";
    // Nom d'utilisateur : root
    $user = "root";
    // Mot de passe : 
    $password_bdd = "root";

    $auth_dsn = "$auth_engine:host=$host:$auth_port;dbname=$auth_bdd";
    $auth_pdo = new PDO($auth_dsn, $user, $password_bdd);

    $app_dsn = "$auth_engine:host=$host:$auth_port;dbname=$app_bdd";
    $app_pdo = new PDO($app_dsn, $user, $password_bdd);

    $json = file_get_contents('php://input');
    $data = json_decode($json,true);

    $lastname = $data["last_name"];
    $firstname = $data["first_name"];
    $birthdate = $data["birth_date"];
    $gender = $data["gender"];
    $email = $data["mail"];

    $requete = $app_pdo->prepare("
    INSERT INTO profiles (last_name,first_name,birth_date,gender,mail)
    VALUES (:last_name,:first_name,:birth_date,:gender,:mail);
    ");

    $requete->execute([
        ':last_name'=>$lastname,
        ':first_name'=>$firstname,
        ':birth_date'=>$birthdate,
        ':gender'=>$gender,
        ':mail'=>$email
    ]);