<?php 
session_start();
require '../inc/pdo.php';
require '../inc/functions/token_functions.php';

if(isset($_SESSION['token'])){
    $check = token_check($_SESSION["token"], $auth_pdo);
    if($check == 'false'){
        header('Location: ../connections/login.php');
        exit();
    } elseif($_SESSION['profile_status'] == 'Inactif') {
        header('Location: ../profiles/settings.php');
        exit();        
    }
}elseif(!isset($_SESSION['token'])){
    header('Location: ../connections/login.php');
    exit();
}

$title = "Groupes rejoints";
    $requete = $app_pdo->prepare('
        SELECT group_id 
        FROM group_members
        WHERE profile_id = :profile_id;
    ');
    $requete -> execute([
        ':profile_id'=> $_SESSION['id']
    ]);
    $result = $requete->fetchAll(PDO::FETCH_ASSOC);

    $group_id = array();

    for($i = 0; $i < count($result);$i++){
        array_push($group_id, $result[$i]['group_id']);
    }

    $requete2 = $app_pdo->prepare('
        SELECT DISTINCT gm.group_id, g.name, g.description, g.status,g.id
        FROM group_members gm
        JOIN groups_table g ON gm.group_id = g.id
        WHERE gm.profile_id = :profile_id;

    ');
    
    $requete2->execute([
        ':profile_id' => $_SESSION['id']
    ]);

    $result2 = $requete2->fetchAll(PDO::FETCH_ASSOC);

    $requete3 = $app_pdo->prepare('
    SELECT DISTINCT gm.group_id, g.name, g.description, g.status,g.id
    FROM group_members gm
    JOIN groups_table g ON gm.group_id = g.id
    WHERE gm.profile_id != :profile_id;
    ');

    $requete3->execute([
        ':profile_id' => $_SESSION['id']
    ]);

    $result3 = $requete3->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo $title?></title>
</head>
<body>
    <div id = "g">
   <h1><?php echo $title?></h1>
   <?php  if ($result2) {
                foreach($result2 as $row){ ?>
    <ul>
        <li>Nom : <?php echo $row['name'] ?></li>
        <li>Description : <?php echo $row['description'] ?></li>
        <li>Statut : <?php echo $row['status'] ?></li>
        <li>Nombre de membre :</li>
        <li><a href="../groups/group.php?id=<?php echo $row['id'] ?>">Entrer dans le groupe</a></li>
    </ul>
    <?php } }
    else {
        echo 'Pas de groupe';
    } ?>
    <a href="../groups/create_group.php"><button>Créer un groupe</button></a>
</div>
<div>
    <h1>Suggestions de groupes</h1>
    <?php  if ($result3 ) {
                foreach($result3 as $row){ 
                    if (!in_array($row, $result2)){?>
    <ul>
        <li>Nom : <?php echo $row['name'] ?></li>
        <li>Description : <?php echo $row['description'] ?></li>
        <li>Statut : <?php echo $row['status'] ?></li>
        <li>Nombre de membre :</li>
        <li><a href="../groups/group.php?id=<?php echo $row['id'] ?>">Rejoindre dans le groupe</a></li>
        <a href=""></a>
    </ul>
    <?php } }}
    else {
        echo 'Pas de groupe';
    } ?>
</div>
</body>
</html>