<?php
session_start();
require '../../classlink_app/inc/pdo.php'; //Besoin du pdo pour se connecter à la bdd

$title = "Vos demandes d'ajouts de groupes";
$group_ID = $_GET['group_id'];
$erreur = "";

// $requete = $app_pdo->prepare('
// SELECT DISTINCT ag.group_id, g.name
// FROM  asked_groups ag
// JOIN groups_table g ON ag.group_id = g.id
// WHERE ag.profile_id = :profile_id;
// ');
// $requete->execute([
//     ':profile_id'=>$_SESSION['id']
// ]);

// $result = $requete->fetch(PDO::FETCH_ASSOC);
// $group_id = $result['group_id'];
// echo $group_id;


$requete2 = $app_pdo->prepare('
SELECT ag.profile_id, p.*
FROM asked_groups ag
JOIN profiles p ON ag.profile_id = p.id
WHERE ag.group_id = :group_id;
');
$requete2->execute([
    ':group_id'=>$group_ID
]);
$result2 = $requete2->fetchAll(PDO::FETCH_ASSOC);
$result2 = $requete2->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result2)) {
    $id_asker = $result2[0]['id'];
} else {
    $erreur = "Il n'y a pas de demande !";
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
            ':group_id' => $group_ID,
            ':profile_id' => $id_asker
        ]);
        
        $request_supp_asked_groups = $app_pdo->prepare('
        DELETE FROM asked_groups WHERE group_id = :group_id
        AND profile_id = :profile_id;
        ');

        $request_supp_asked_groups->execute([
            ':group_id' => $group_ID,
            ':profile_id' => $id_asker
        ]);
        echo 'Vv';

    }
    elseif($input == 'refuser'){
        $request_supp_asked_groups2 = $app_pdo->prepare('
        DELETE FROM asked_groups WHERE group_id = :group_id
        AND profile_id = :profile_id;
        ');

        $request_supp_asked_groups2->execute([
            ':group_id' => $group_ID,
            ':profile_id' => $id_asker
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
    <?php if($result2){
            foreach($result2 as $row2){?>
            <p><?php echo $row2['last_name']." ". $row2['first_name']." ". $row2['id']  ?> souhaite rejoindre votre groupe </p>
            <div class='div-button-accept'><button id="<?= $row2['profile_id']?>">Accepter<button></div>
            <div class='div-button-reject'><button id="<?= $row2['profile_id']?>">Refuser</button></div>
            <?php }}
            else { ?>
            <p><?php echo $erreur ?></p>
            <?php } ?>
    </div>
    <a href="./group.php?id=<?php echo $group_ID ?>"><button>Retour</button></a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        const divButtonsAccept = document.getElementsByClassName("div-button-accept");
Array.from(divButtonsAccept).forEach(divButton => {
    divButton.addEventListener("click", () => {
        const statusValue = 'accept';
        console.log('la');
        const id_btn = divButton.firstElementChild.id;
        $.ajax({
            url: 'manage_asking.php',
            method: 'POST',
            data: { group_id: <?php echo $group_ID ?>, user_id: id_btn, status: statusValue },
            success: function(response) {
                console.log(response);
            },
        });
    });
});

const divButtonsReject = document.getElementsByClassName("div-button-reject");
Array.from(divButtonsReject).forEach(divButton => {
    divButton.addEventListener("click", () => {
        const statusValue = 'reject';
        console.log('la');
        const id_btn = divButton.firstElementChild.id;
        $.ajax({
            url: 'manage_asking.php',
            method: 'POST',
            data: { group_id: <?php echo $group_ID ?>, user_id: id_btn, status: statusValue },
            success: function(response) {
                console.log(response);
            },
        });
    });
});
    </script>
</body>
</html>

