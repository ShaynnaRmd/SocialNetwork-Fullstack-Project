<?php
require '../inc/pdo.php';
require '../inc/functions/token_functions.php';

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/create_group.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <title>Groupes</title>
</head>
<body>
    <?php include '../inc/tpl/header.php'; ?>
    <main>
        <div class="left-side">
            <div class="informations">
                <div class="top">
                    <div class="img"><img src="../../assets/img/default_pp.jpg" alt=""></div>
                    <div class="name">
                        <p>Prénom Nom</p>
                    </div>
                    <div class="separator"></div>
                </div>
                <div class="mid">
                    <div class="personnal-info">
                        <div><p>Anniversaire <span>: 2003-10-08</span></p></div>
                        <div><p>Genre <span>: Homme</span></p></div>
                        <div><p>E-mail <span>: test@gmail.com</span></p></div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="btn2"><a href=""><button>Modifier</button></a></div> <!-- Rajouter le lien vers modifier profil--> 
                </div>
            </div>
            <div class="btn">
                <a href=""><button>Se déconnecter</button></a> <!-- Rajouter le lien vers logout--> 
            </div>
        </div>
        <div class="create">
            <div class="header">
                <div><h2>Créer un groupe</h2></div>
            </div>
            <div class="main">
                <form method="POST">
                    <div>
                        <label for="name">Nom du groupe</label>
                        <input id="name" type="text">
                    </div>
                    <div>
                        <label for="subject">Sujet du groupe</label>
                        <input id="subject" type="text">
                    </div>
                    <div>
                        <label for="statut">Statut du groupe</label>
                        <select name="statut" id="statut">
                            <option value="" selected disabled hidden>Choisir une option</option>
                            <option value="Public">Publique</option>
                            <option value="private">Privé</option>
                        </select>
                    </div>
                    <div>
                        <label for="image">Image du groupe</label>
                        <input type="file" id="fileInput" class="custom-file-input">
                        <label for="fileInput" class="custom-file-label">Choisir un fichier</label>

                    </div>
                </form>
                <div class="planet"><img src="../../assets/img/create_groups_planet.svg" alt=""></div>
            </div>
            <div class="bottom-main">
                <div><button>Créer un groupe</button></div>
            </div>
        </div>
    </main>
    <script src="../../assets/js/notifications.js"></script>
</body>
</html>