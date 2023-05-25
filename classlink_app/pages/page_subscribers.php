<?php
    session_start();
    require '../inc/pdo.php'; 
    $display_subscribers_request = $app_pdo->prepare('
    SELECT profiles.id, last_name, first_name, pp_image
    FROM profiles
    LEFT JOIN subscribers_page ON profiles.id = subscribers_page.profile_id
    WHERE subscribers_page.page_id = :page_id
    ');

    $display_subscribers_request->execute([
        ":page_id" => $_SESSION['page_id']
    ]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <title>Liste des abonnés</title>
</head>
<body>
    <?php include '../inc/tpl/header.php' ?>

    <div>
        <?php foreach ($display_subscribers_request as $subscriber){?>
        <div>
            <?= $subscriber['first_name'] . ' ' . $subscriber['last_name']; ?>
            <div class="div-button"><button id="<?= $subscriber['id'] ?>">Ajouter comme admin</button></div>
        <?php } ?>
        </div>
    </div>

    <script>
    const divButtons = document.getElementsByClassName("div-button");
    Array.from(divButtons).forEach(divButton => {
        divButton.addEventListener("click", () => {
            const id_btn = divButton.firstElementChild.id;
            console.log(id_btn);
        });
    });
    </script>

</body>
</html>