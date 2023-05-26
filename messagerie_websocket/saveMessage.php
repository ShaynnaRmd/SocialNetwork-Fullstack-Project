<?php
require_once 'pdo.php';
    session_start();
    //recuperer les donnees de la requete ajax
    
    $room = $_POST['room'] ;
    $messages = $_POST['msg'] ;
    $sender = $_POST['name'];
    $date = date('Y-m-d H:i:s');
    
    
    $sql = "INSERT INTO group_chat_messages(group_id, member_id, message,created_at) VALUES (:room, :sender, :messages, :date)";
    $stmt = $messaging_pdo->prepare($sql);
    $stmt->execute(
        array(
            ':room' => $room,
            ':messages' => $messages,
            ':sender' => $sender,
            ':date' => $date
        )
    );
    $sql = "select * from group_chat_messages where group_id = :room ";
    $stmt = $messaging_pdo->prepare($sql);
   $stmt->execute(

        array(
            ':room' => $room,
          
        )
    );
    $reponse = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $reponse['id'];
    //encoyer une reponse au client
    if($stmt->rowCount() > 0){
        $response = array(
            'id' => $id,
            'status' => 'success',
            'msg' => 'Message sent successfully'
        );
    }else{
        $response = array(
            'status' => 'error',
            'msg' => 'Message not sent'
        );
    }
    echo json_encode($response);
    exit();