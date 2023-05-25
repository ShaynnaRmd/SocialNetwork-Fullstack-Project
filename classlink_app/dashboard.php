<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="../assets/js/script.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <title>Classlink-Dashboard</title>
</head>
<body>
    <section class="header">
        <a class="logo" href="">
            <img src="../assets/img/white_logo.svg" alt="logo">
        </a>
        <div class="input-box">
            <input id="input" type="text" placeholder="Recherche...">
            <span class="search">
                <i class="uil uil-search search-icon"></i>
                <ul class="dropdown" id="dropdown"></ul>
            </span>
            <i class="uil uil-times close-icon"></i>
        </div>
        <a class="profile-icon-header" href="">
            <img src="../assets/img/ellipse.svg" alt="profile-icon">
        </a>
        <a class="tv-icon" href="">
            <img src="../assets/img/tv-header.svg" alt="tv-icon">
        </a>
        <a class="notifications" href="">
            <img src="../assets/img/header-bell.svg" alt="bell-icon">
        </a>
        <a class="messages-icon" href="">
            <img src="../assets/img/messages-icon.svg" alt="messages-icon">
        </a>
    </section>
    <section class="profil">
        <div class="profile-head">
            <img class="profile-pic" src="../assets/img/ellipse.svg" alt="profile-pic">
            <h3>Nom Prénom</h3>
        </div><hr>
        <div class="profile-infos">
            <p>Age: <span>21</span></p>
            <p>Genre: <span>Homme</span></p>
            <p>Email: <span>email_test@gmail.com</span></p>
        </div>
        <div>
            <button class="profile-button">Modifier</button>
        </div>
    </section>
    <section class="create-post">
        <img class="post-profile-pic" src="../assets/img/ellipse.svg" alt="profile-icon">
        <button class="post-button">Exprimez-vous...</button>
    </section>
    <section class="informations">
        <p>Relations<span>57</span></p><hr>
        <p>Groupes<span>4</span></p><hr>
        <p>Pages<span>7</span></p>
    </section>
    <section class="suggestions">
        <h3 class="suggestions-title">Suggestions</h3>
        <h4>Personnes:</h4>
        <div class="suggestion-line">
            <img src="../assets/img/empty-pp.svg" alt="profile-icon">
            <p>Prénom Nom</p>
            <button class="quick-add">+</button>
        </div>
        <div class="suggestion-line">
            <img src="../assets/img/empty-pp.svg" alt="profile-icon">
            <p>Prénom Nom</p>
            <button class="quick-add">+</button>
        </div>
        <div class="suggestion-line">
            <img src="../assets/img/empty-pp.svg" alt="profile-icon">
            <p>Prénom Nom</p>
            <button class="quick-add">+</button>
        </div>
        <div class="suggestion-line">
            <img src="../assets/img/empty-pp.svg" alt="profile-icon">
            <p>Prénom Nom</p>
            <button class="quick-add">+</button>
        </div>
        <h3 class="pages-title">Pages</h3>
        <div class="pages-container">
            <div class="item1"></div>
            <div class="item2"></div>
            <div class="item3"></div>
            <div class="item4"></div>
        </div>

    </section>
    <section class="timeline">
        <div class="post-information">
            <img class="post-profile-pic" src="../assets/img/ellipse.svg" alt="profile-icon">
            <h3 class="post-name">Prénom Nom</h3>
        </div>
        <p class="post-description">Lorem ipsum dolor sit amet consectetur adipisicing elit
            <span id="dots">...</span>
            <span id="more">Iure consequatur dolore quasi impedit at, quas quibusdam libero itaque, nisi, consectetur accusamus dolores quisquam vel doloremque id delectus a ipsum aperiam?</span>
        </p>
        <a class="read-more" onclick="readMore()" id="myBtn">Voir plus</a>
        <div>
            <img class="post-image" src="../assets/img/rectangle.png" alt="post">
        </div>
        <div>
            <p class="nb-likes">3157</p>
            <p class="nb-comments">348 Commentaires</p>
        </div><br><br>
        <div class="interactions">
            <button class="like"><img src="../assets/img/Thumbs-up.svg" class="like-icon" alt="like">J'aime</button>
            <button class="comment"><img src="../assets/img/Messenger.svg" class="comment-icon" alt="like">Commenter</button>
        </div>
    </section>
    <button class="disconnect">Se déconnecter</button> 

    <script>
        let inputBox = document.querySelector(".input-box"),
            search = document.querySelector(".search"),
            closeIcon = document.querySelector(".close-icon")

        search.addEventListener("click", () => inputBox.classList.add("open"))
        closeIcon.addEventListener("click", () => inputBox.classList.remove("open"))
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
          
          function fetchData(){
            let value = $("#input").val(); // Permet de récupérer la valeur de l'input
            console.log(value)
            if (value == '') { // if la valeur de value est null
               $('#dropdown').css('display', 'none');
            }
            $.post("index.php", 
                  {
                    'value' : value
                  },
                  function(data, status){
                      if (data != "not found") {
                        $('#dropdown').css('display', 'block');
                        $('#dropdown').html(data);
                      }
                  });
          }
          $('#input').on('input', fetchData);
          $("body").on('click', () => {
            $('#dropdown').css('display', 'none');
          });
          $('#input').on('click', fetchData);
      });
    </script>


</body>
</html>
