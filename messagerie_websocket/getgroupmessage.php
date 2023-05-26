<?php
require_once 'pdo.php';
    session_start();
    //recuperer les donnees de la requete ajax
    $room = $_POST['room'];
    $_SESSION['room'] = $room;

    $sql = "SELECT * FROM group_chat_messages WHERE group_id = '$room'";
    $stmt = $messaging_pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $final= json_encode($result);
    echo $final;
  


    exit();