<?php
//recuperer les messages privés

require_once "pdo.php";
session_start();
$friend=$_POST['friend'];
$sql = "SELECT * FROM private_chats WHERE (sender_id = :id AND receiver_id = :friend) OR (sender_id = :friend AND receiver_id = :id)";
$stmt = $messaging_pdo->prepare($sql);
$stmt->execute(array(
    ':id' => $_SESSION['id'],
    ':friend' => $friend,
    ':user_to' => $_SESSION['id'],
    ':user_from' => $friend
));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$final= json_encode($result);
echo $final;