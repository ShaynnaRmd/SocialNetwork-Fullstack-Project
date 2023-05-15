<?php
    // Ces six informations sont nécessaires pour vous connecter à une BDD :
    // Type de moteur de BDD : mysql
    $app_engine = "mysql";
    // Hôte : localhost
    $host_app = "localhost";

    // Port : 3306 (par défaut pour MySQL, avec MAMP macOS c'est 8889)
    $app_port = 3306; // port MAMP
    // Nom de la BDD (facultatif) : sakila
    $app_bdd = "app";
    // Nom d'utilisateur : root
    $user_bdd = "root";
    // Mot de passe : 
    $password_app = "";

    $app_dsn = "$app_engine:host=$host_app:$app_port;dbname=$app_bdd";
    $app_pdo = new PDO($app_dsn, $user_bdd, $password_app);
