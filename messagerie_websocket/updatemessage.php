<?php
require_once 'pdo.php';
//mettre a jour le message et lheure dans la base de donnée avec le pdo
$sql= "UPDATE private_chats SET message = :message, modifie_time = :time WHERE id = :id";

    $stmt = $messaging_pdo->prepare($sql);
    $stmt->execute(array(
        ':message' => $_POST['message'],
        ':id' => $_POST['id'],
        ':time' => $_POST['time']
    ));
    if($stmt->rowCount() > 0){
        echo "success";
    }else{
        echo "error";
        
    }
    
    exit();
?>