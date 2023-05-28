<?php
session_start();
require '../../classlink_app/inc/pdo.php'; //Besoin du pdo pour se connecter à la bdd

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

if (!empty($result2)) {
    $id_asker = $result2[0]['id'];
} else {
    $erreur = "Il n'y a pas de demande !";
}



$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
$input = filter_input(INPUT_SERVER, 'input');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/asked.css">
    <title>Ajouts de membres</title>
</head>
<body>
    <header>
    </header>
<div class = "asked" >
    <div class = "container"> 
    <div class = "titre"><h2>Ajouts de membres</h2></div>    
        <?php if($result2){
            foreach($result2 as $row2){?>
            <div class = "info-member">
                <p id = "member"><?php echo $row2['last_name']." ". $row2['first_name'] ?></p><p id = "requete"> souhaite rejoindre votre groupe. </p>
                <div class = "button">
                        <div class='div-button-accept' ><input class="input" type="submit" id ="<?php echo $row2['id'] ?>" value = "accept" name = "accept"></div>
                        <div class='div-button-reject' ><input class="input" type="submit" id = "<?php echo $row2['id'] ?>" value = "reject" name = "reject"></div>
                </div>
                <?php }}
                else { ?>
                <p><?php echo $erreur ?></p>
                <?php } ?>
            </div>
            
    </div>
</div>
    <br>
    <a href="./group.php?id=<?php echo $group_ID ?>"><button>Retour</button></a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        const divButtonsAccept = document.getElementsByClassName("div-button-accept");
    Array.from(divButtonsAccept).forEach(divButton => {
    divButton.addEventListener("click", () => {
        const statusValue = 'accept';
        const id_btn = divButton.firstElementChild.id;
        console.log(id_btn);
        $.ajax({
            url: 'manage_asking.php',
            method: 'POST',
            data: { group_id: <?php echo $group_ID ?>, user_id: id_btn, status: statusValue },
            success: function(response) {
                location.reload()
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
                location.reload()
            },
        });
    });
});
    </script>
</body>
</html>

