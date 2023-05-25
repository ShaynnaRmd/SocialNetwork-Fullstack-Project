<?php
    session_start();
    require '../inc/pdo.php';
    require '../inc/functions/token_functions.php';

    $group_count_request = $app_pdo->prepare("
        SELECT COUNT(group_id) AS 'group_number' FROM profiles
        LEFT JOIN group_members ON profile_id = profiles.id
        WHERE profile_id = :id
    ");

    $group_count_request->execute([
        ':id' => $_SESSION['id']
    ]);

    $group_count_result = $group_count_request->fetch(PDO::FETCH_ASSOC);

    var_dump($group_count_result);

    $group_members_count_request = $app_pdo->prepare("
        SELECT COUNT(profile_id) AS 'number_of_member' FROM group_members
        LEFT JOIN profiles ON profile
    ")
?>