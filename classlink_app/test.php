<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <title>ClassLink - Accueil</title>
</head>
<body>
    <?php include './inc/tpl/header.php' ?>
    <main>
        <div class='dashboard-leftside'>
            <div class="informations">
                <div class="top">
                        <div class="img"><img src="../../assets/img/default_pp.jpg" alt=""></div>
                        <div class="name">
                            <p><?= "$firstname $lastname" ?></p>
                        </div>
                    <div class="separator"></div>
                </div>
                <div class="mid">
                    <div class="personnal-info">
                            <div><p>Age <span>: <?= $age ?></span></p></div>
                            <div><p>Genre <span>: <?= $gender ?></span></p></div>
                            <div><p>E-mail <span>: <?= $mail ?></span></p></div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="btn2"><button id="modify-profile-btn">Modifier</button></div> <!-- Rajouter le lien vers modifier profil--> 
                </div>
            </div>
            <div class='relations-groups-pages'>
                <div>
                    <div class='text-number'>
                        <div class='txt'><p>Relations</p></div>
                        <div><p><?= $numbers_of_relations ?></p></div>
                    </div>
                    <div class='separator2'></div>
                </div>
                <div>
                    <div class='text-number'>
                        <div class='txt'><p>Groups</p></div>
                        <div><p><?= $numbers_of_groups ?></p></div>
                    </div>
                    <div class='separator2'></div>
                </div>
                <div>
                    <div class='text-number'>
                        <div class='txt'><p>Pages</p></div>
                        <div><p><?= $numbers_of_pages ?></p></div>
                    </div>
                </div>
            </div>
            <div class="btn">
                <button id="logout">Se déconnecter</button> <!-- Rajouter le lien vers logout--> 
            </div>
        </div>
        <div class='dashboard-mid'>
            <div class="create-post" id='create-post'>
                <div class="pp-post"><img src="" alt=""></div>
                <div class="fake-input"><p>Exprimez-vous...</p></div>
            </div>
            <!-- <div class="post">
        <div class="top-post">
            <div class="post-pp"><img src="" alt=""></div>
            <div class="post-name"><p>Djedje Gboble</p></div>
            <div class="post-text"><p>lorem ipsum</p></div>
            <div class="post-date"><p>Le 27/06/2023, à 22:47</p></div>
            <div class="plus"><p>Afficher plus...</p></div>
        </div>
        <div class="img-post" id="picspost" style="background-image: url('<?= $path_img.$image ?>')"></div>
        <div class="bottom-post">
            <div class="up">
                <div class="nb-like">
                    <div><img src="../assets/img/thumbs-up.svg" alt=""></div>
                    <div><img src="../assets/img/heart.svg" alt=""></div>
                    <div><img src="../assets/img/smile.svg" alt=""></div>
                    <div class="nb"><p>3125</p></div>
                </div>
                <div class="nb-comments"><p>134 Commentaires</p></div>
            </div>
            <div class="down">
                <div class='left'>
                    <div><img src="../assets/img/thumbs-up.svg" alt=""></div>
                    <div class="text"><p>J'aime</p></div>
                </div>
                <div class="right">
                    <div><img src="../assets/img/comment.svg" alt=""></div>
                    <div class="text"><p>Commenter</p></div>
                </div>
            </div> -->
            </div>
        <div class='dashboard-right'>
            <div class='suggestions'>
                <div class='suggestions-personnes'>
                    <div><h3>Suggestions</h3></div>
                    <div class='personnes'>
                        <div><h5>Personnes :</h5></div>
                        <div class='list'>
                            <div>
                                <div class='list-img'><img src="../assets/img/default_pp.jpg" alt=""></div>
                                <div class='list-p'><p>Nom Prénom</p></div>
                                <div><button></button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
    <!-- <div class="link">
    <h1>Test</h1>
    <a href="./connections/logout.php">Déconnexion</a>
    <a href="./pages/create_page.php">Créer une page</a>
    <a href="./profiles/profile.php">PROFIL</a> -->
    <script src="../assets/js/notifications.js"></script>
    <script>
        const logoutButton = document.getElementById('logout');
        logoutButton.addEventListener('click', () => {
            window.location.href = './connections/logout.php';
        })

        const modifyProfileBtn = document.getElementById('modify-profile-btn');
        modifyProfileBtn.addEventListener('click', () => {
            window.location.href = './profiles/settings_edition_mode.php';
        })
    </script>
</body>
</html>