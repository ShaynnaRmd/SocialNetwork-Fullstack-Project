<?php
session_start();
require '../../classlink_app/inc/pdo.php'; //Besoin du pdo pour se connecter à la bdd

$title = "Vos demandes d'ajouts de groupes";

$requete = $app_pdo->prepare('
SELECT DISTINCT ag.group_id, g.name
FROM  asked_groups ag
JOIN groups_table g ON ag.group_id = g.id
WHERE ag.profile_id = :profile_id;
');
$requete->execute([
    ':profile_id'=>$_SESSION['id']
]);

$result = $requete->fetchAll(PDO::FETCH_ASSOC);
var_dump($result);

$requete2 = $app_pdo->prepare('
SELECT DISTINCT ag.profile_id,p.last_name,p.first_name
FROM asked_groups ag
JOIN profiles p ON ag.profile_id = p.id
WHERE ag.profile_id = :profile_id;
');
$requete2->execute([
    ':profile_id'=>$_SESSION['id']
]);

$result2 = $requete2->fetchAll(PDO::FETCH_ASSOC);

$asked_id = array();

for($i = 0; $i < count($result);$i++){
    array_push($asked_id, $result[$i]['group_id']);
}
for($i = 0; $i < count($result2);$i++){
    array_push($asked_id,$result2[$i]['profile_id']);
}

$requete3 = $app_pdo->prepare('
SELECT DISTINCT ag.group_id, g.creator_profile_id
FROM asked_groups ag
JOIN groups_table g ON ag.group_id = g.id
WHERE g.creator_profile_id = :creator_profile_id
');

$requete3->execute([
    ':creator_profile_id'=> $_SESSION['id']
]);

$result3 = $requete3->fetch(PDO::FETCH_ASSOC);
if(isset($result3['group_id'])){
    $group_id = $result3['group_id'];
}

$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
$input = filter_input(INPUT_SERVER, 'input');
if($method == 'POST'){
    if($input == 'accepter'){
        $request_accept = $app_pdo->prepare('
        INSERT INTO group_members (group_id, profile_id)
        VALUES (:group_id, :profile_id);
        ');
        $request_accept->execute([
            ':group_id' => $group_id,
            ':profile_id' => $_SESSION['id']
        ]);
        
        $request_supp_asked_groups = $app_pdo->prepare('
        DELETE FROM asked_groups WHERE group_id = :group_id
        AND profile_id = :profile_id;
        ');

        $request_supp_asked_groups->execute([
            ':group_id' => $group_id,
            ':profile_id' => $_SESSION['id']
        ]);

    }
    elseif($input == 'refuser'){
        $request_supp_asked_groups2 = $app_pdo->prepare('
        DELETE FROM asked_groups WHERE group_id = :group_id
        AND profile_id = :profile_id;
        ');

        $request_supp_asked_groups2->execute([
            ':group_id' => $group_id,
            ':profile_id' => $_SESSION['id']
        ]);
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?> </title>
</head>
<body>
    <h1><?php echo $title ?></h1>
    <div>
        <?php if($result && $result2){
            foreach($result2 as $row2){
                foreach($result as $row){?>
            <p><?php echo $row2['last_name']." ". $row2['first_name']  ?> souhaite entrer dans le groupe : <?php echo $row['name'] ?></p>
            <form method = 'POST'>
                <input type="submit" name = "input" value = "accepter">
                <input type="submit" name = "input" value = "refuser">
                </form>
            <?php }}} ?>
    </div>  
</body>
</html>

