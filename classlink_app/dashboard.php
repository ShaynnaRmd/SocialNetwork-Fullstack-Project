<?php
session_start();
require './inc/functions/token_functions.php';
require './inc/pdo.php';
    if(isset($_SESSION['token'])){
        $check = token_check($_SESSION["token"], $auth_pdo);
        if($check == 'false'){
            header('Location: ./connections/login.php');
        }
    }elseif(!isset($_SESSION['token'])){
        header('Location: ./connections/login.php');
    }
$dirimg = '../assets/img/';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/header.css">
    <title>Document</title>
</head>
<body>
    <?php include './inc/tpl/header.php' ?>
    <h1>Test</h1>
    <a href="./connections/logout.php">Déconnexion</a>
    <a href="./profiles/profile.php">Profile</a>
</body>
</html>