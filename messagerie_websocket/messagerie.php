<?php

session_start();
$room = null;
if (isset($_POST['submit'])) {
	if(isset($_POST['name'])){
		$_SESSION['name'] = $_POST['name'];
	}
	
}

$_SESSION['id'] = 110;

if(!isset($_SESSION['name'])){
    header("Location: index.php");
}
if(!isset($_SESSION['room'])){
    $_SESSION['room'] = 1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="messagerie.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

</head>

 

<body class="mess">
 

   <dialog>
   <p>voulez vous vraiment supprimer ce message ?</p><button id='oui'>oui</button><button id='non'>non</button>
   </dialog>
   <dialog>
    <input id="editedContent" type="text" placeholder="Entrez le nouveau message">
    <button id='modifier'>Modifier</button><button id='annuler'>annuler</button>
   </dialog>


   
    <div  method="post" id="form" style="display:none">
    <input id="group_name" type="text" name="room" placeholder="nom du Groupe" required>
    <textarea id="descriptions" name="description"  cols="10" rows="10" placeholder="description du groupe"></textarea>
    <button  id="creategroup">creer</button>
</div>
 
    <button class="changer" onclick="change()">Changer de theme</button>
    <section class="messagerie">
        <div class="dashboard">
            <div class="header">
                <h1>Messages</h1>
                <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="#FF784F" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                </div>
            </div>
          
            <div class="liste_bouton"> 
            <div class="boutton white orange" id="privés" onclick="active(this)">
                <p>Messages Privés</p>
            </div>
            <div id="groupmessage" class="boutton white" onclick="active(this)">
                <p>Messages Groupe</P>
            </div>
            </div>
             
            <ul class="liste">
                

            </ul>
        </div>
        <div class='zone_de_texte'>
            <div class="top_profile">
                <div class="name_photo">
                    <div class="circle_image"><img src="https://img.nrj.fr/EIZG0nl4nXzmTzHGUU7xvpfEq90=/800x450/smart/medias%2F2022%2F10%2F63401522e919e_6340152ebd63f.jpg" alt="profile"></div>
                    <p>Name</p>
                </div>
                <div class="option">
                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg></p></div>  
            </div>
            <div class="write " id="write">
            
                    <i id="loading"></i>
                   
                    

            </div>
            <div class="message_section " id="input">
              
                <input type="text" name="message" id="message" placeholder="Ecrivez votre message">
                <button type="submit" name="submit" id="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-short" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5z"/>
</svg></button>

         
            </div>
            
        </div>
   </section>
</body>


<script>



    var name = "<?php echo $_SESSION['name']; ?>";


    var scrollContainer = document.getElementById('write');
    
    for(var a=0;a<100; a++){
        let ul = document.querySelector(".liste");
        ul.innerHTML += "<li><div class='circle_image'><img src='https://img.nrj.fr/EIZG0nl4nXzmTzHGUU7xvpfEq90=/800x450/smart/medias%2F2022%2F10%2F63401522e919e_6340152ebd63f.jpg' alt='profile'></div><div class='name_message'><p>john</p><p>ytftfuguy freyg erfgeryug </p></div></li>";
    }
    var boutton = document.querySelectorAll(".boutton");
   function active(e){
        boutton.forEach(element => {
            element.classList.remove("orange");
        });
       e.classList.add("orange");
       
   }
   //changer de theme
    function change(){
         var body = document.querySelector("body");
         body.classList.toggle("dark_back");
         var messagerie = document.querySelector(".dashboard");
        messagerie.classList.toggle("dark");
       var zone_de_texte = document.querySelector(".zone_de_texte");
        zone_de_texte.classList.toggle("dark");
        var write = document.getElementById("write");
        write.classList.toggle("dark_write");
        var message_section = document.querySelector(".message_section");
        message_section.classList.toggle("dark_message_section");
        var input = document.querySelector("input");
        input.classList.toggle("dark_input");

    }



    
</script>

 <script>
    function option(){$(document).ready(function() {
  $(".messagecontentant").on("contextmenu", function(event) {
    event.preventDefault(); // Empêche le menu contextuel par défaut de s'afficher

    var message = $(this);
    var messageId = message.data("id");
    //supprimer tout les context menu sil y en a
    $(".context-menu").remove();
    var contextMenu = $("<div class='context-menu'>")
      .css({
        top: event.pageY + "px",
        left: event.pageX + "px"
      })
      .appendTo("body");
      //verifier si le message est envoyer ou recu

    if(message.hasClass('recever_box')){
        $("<div class='context-menu-option'>Modifier</div>")
      .appendTo(contextMenu)
      .click(function() {
        var input= $(document).find("dialog")[1];
      
        
        input.style.borderRadius="0.5em";
        input.style.backgroundColor="white";
        input.style.padding="20px";
        input.style.position="absolute";
        input.style.top="50%";
        input.style.left="50%";
        input.style.transform="translate(-50%,-50%)";
        input.style.boxShadow="0px 0px 10px rgba(0,0,0,0.5)";
        input.style.border="none";
        input.style.gap="10px";
        input.style.flexDirection="column";
        input.style.overflow="hidden";
        input.showModal();
        input.querySelector("#editedContent").value=message.find('p').text();
        input.querySelector("#modifier").addEventListener("click", function() {
           
            var editedContent = input.querySelector("#editedContent").value;
            message.find('p').text(editedContent);
           // Enregistrer le nouveau contenu dans la base de données
          //recuperer le id du message
          messageId = message.find('.receiver').data("id");
          console.log(messageId);
          console.log(editedContent);
          saveMessageToDatabase(messageId, editedContent);
        
          input.close();

        });

        input.querySelector("#annuler").addEventListener("click", function() {
          input.close();
        });
       
        contextMenu.remove();
      });
  
    }


    $("<div class='context-menu-option'>Supprimer</div>")
      .appendTo(contextMenu)
      .click(function() {
        var messageId = message.find('.receiver').data("id");
        var messageIdi = message.find('.sender').data("id");
        contextMenu.remove();
        //creer une balise dialog pour confirmer la suppression
        var dialog=$(document).find("dialog")[0];
        dialog.style.width="300px";
        
        dialog.style.borderRadius="0.5em";
        dialog.style.backgroundColor="white";
        dialog.style.padding="20px";
        dialog.style.position="absolute";
        dialog.style.top="50%";
        dialog.style.left="50%";
        dialog.style.transform="translate(-50%,-50%)";
        dialog.style.boxShadow="0px 0px 10px rgba(0,0,0,0.5)";
        dialog.style.border="none";
        dialog.style.gap="10px";
        dialog.style.flexDirection="column";
        dialog.style.overflow="hidden";
        dialog.showModal();
       
       
        

       dialog.querySelector("#oui").addEventListener("click",function(){
         dialog.close();
          if(messageId != null){
          message.remove();
          deleteMessage(messageId);
          write();
          option();
          }
          else if(messageIdi != null){
           dialog.close();
            message.remove();
            deleteMessage(messageIdi);
            write();
            option();
          }
         
     
        });
        dialog.querySelector("#non").addEventListener("click",function(){
          //close the dialog without display none
            dialog.close();
         
          option(); 
        });
    
       
         
      });

    $(document).on("click", function() {
      contextMenu.remove();
    });
  });
});

}
    function drag(){
        $(document).ready(function() {
                                $('.draggableElement').draggable({
                                    revert: 'invalid', // Revenir à la position initiale si droppé en dehors de la zone cible
                                    axis: 'x', // Déplacer l'élément uniquement horizontalement
                                    //deplacer que vers la droite
                                    
                                    drag: function(event, ui) {
                                     
                                    var $draggable = $(this);
                                    var xPos = ui.position.left;
                                    var containerWidth = $draggable.parent().parent().width();
                                    var opacity = 0.5 - xPos / (containerWidth); // Calculer l'opacité en fonction de la position

                                    $draggable.css('opacity', opacity);
                                    },
                                    stop: function(event, ui) {
                                    var $draggable = $(this);
                                    var xPos = ui.offset.left - $draggable.parent().offset().left;

                                    
                                   
                                     // Supprime le message dans la base de donnees s'il est glisser trop loin
                                    var containerWidth = $draggable.parent().parent().width();
                                    if (xPos > containerWidth * 0.6) {
                                        var id = $draggable.attr('id');
                                        $.ajax({
                                            type: "POST",
                                            url: "delMessage.php",
                                            data: {id: id },
                                            success: function(data) {
                                                $draggable.parent().remove();
                                                write();
                                            }
                                        });

                                    }
                                    else {
                                        $draggable.css('opacity', 1);
                                    }
                                    }
                                });
                                })
    }
    function dragleft(){
        $(document).ready(function() {
                                $('.draggableElementleft').draggable({
                                    revert: 'invalid', // Revenir à la position initiale si droppé en dehors de la zone cible
                                    axis: 'x', // Déplacer l'élément uniquement horizontalement
                                    //deplacer que vers la droite
                                    
                                    drag: function(event, ui) {
                                     
                                    var $draggable = $(this);
                                    var xPos = ui.position.left;
                                    var containerWidth = $draggable.parent().parent().width();
                                    var opacity = 0.5 - xPos / (containerWidth/2); // Calculer l'opacité en fonction de la position
                                    //couleur plus foncee si on glisse vers la gauche

                                    $draggable.css('opacity', opacity);
                                    },
                                    stop: function(event, ui) {
                                        
                                  // supprime le message si il est glisser trop loin vers la gauche
                                    var $draggable = $(this);
                                    var xPos = ui.offset.left - $draggable.parent().offset().left;

                                    
                                   
                                     // Supprime le message dans la base de donnees s'il est glisser trop loin
                                    var containerWidth = $draggable.parent().parent().width();
                                    if (xPos < containerWidth * 0.1) {
                                        var id = $draggable.attr('id');
                                        $.ajax({
                                            type: "POST",
                                            url: "delMessage.php",
                                            data: {id: id },
                                            success: function(data) {
                                                $draggable.parent().remove();
                                                write();
                                            }
                                        });


                                    }
                                    else {
                                        $draggable.css('opacity', 1);
                                    }
                                    }
                                });
                                })
    }
		
        var conn = new WebSocket(`ws://localhost:8080?room=<?php echo $_SESSION['room']; ?>`);
        //function pur  afficher ecrivez un message si write ne contient pas de div avec une class sender ou receiver
        function write(){
            var write = document.getElementById("write");
            var div = write.getElementsByTagName("div");
            if(div.length == 0){
                var html = "<div class='writer'><p>Ecrivez un message</p></div>";
                jQuery("#write").append(html);
            }
           else if(div.length > 0){
               jQuery(".writer").remove();
           }
        }
      
        

  
       
     
         
        // jQuery("#submit").click(function() {
           
        //     var msg = jQuery("#message").val();
        //     var room = 
        //     var name = "<?php echo $_SESSION['name']; ?>"
        //     var hour = new Date().getHours();
        //     var minute = new Date().getMinutes();
        //     var time = hour + ":" + minute;
        //     var content = {
        //         msg: msg,
        //         name: name,
        //         room: room,
        //         time: time
        //     };
        
        //     $.ajax({
        //         type: "POST",
        //         url: "saveMessage.php",
        //         data: {msg: msg, name: name, room: room, time: time },
        //         success: function(data) {
        //             var data = JSON.parse(data);
        //             console.log(data);
        //             //remplacer le id temporaire par le id de la base de donnée
        //             var id = data.id;
        //             var temporaire_id = document.getElementById("temporaire_id");
        //             temporaire_id.id = id;
        //             temporaire_id.dataset.id = id;
                
                    
        //         }
               
          
        //     });
        //     conn.send(JSON.stringify(content));
        //     var html = "<div id='temporaire_id'  class='recever_box messagecontentant'><div class='row'><div class='circle_image'><img src='https://img.nrj.fr/EIZG0nl4nXzmTzHGUU7xvpfEq90=/800x450/smart/medias%2F2022%2F10%2F63401522e919e_6340152ebd63f.jpg' alt='profile'></div><div class='draggableElement receiver  bullemessage' data-id='temporaire_id'><p>" + msg + "</p></div></div><div class='time'>"+time+"</div></div>";
        //     drag();
        //     option();
        //     write();
        //    jQuery("#write").append(html);
        //    scrollContainer.scrollTop = scrollContainer.scrollHeight;
        //    jQuery("#message").val("");
            
         
            

        // });

        //function pour envoyer le message avec la touche entrer si on est focus sur le input
        $("#message").keypress(function(e) {
            if (e.which == 13) {
                $("#submit").click();
            }
        });
        //modifier un message dans une div editable et enregister quand on est plus focus
        $(document).on('focusout', '.receiver', function() {
            $(this).attr('contenteditable', 'false');
            //change opacity of the div
            $(this).css("opacity", "0.5");
            var id = $(this).attr("id");
            var message = $(this).text();
            var time = new Date().getHours() + ":" + new Date().getMinutes();
          
            
            $.ajax({
                type: "POST",
                url: "updateMessage.php",
                data: {id: id, message: message ,time: time},
                success: function(data) {
                  
                    console.log(data);
                },
                complete:function(){
                    $('.receiver').css('opacity', '1');
                    $(".receiver").attr('contenteditable', 'true');
                    console.log("complete");
                }
            });
          
           
        });
        //function updateMessage
        function saveMessageToDatabase(messageId, editedContent) {
        $.ajax({
            type: "POST",
            url: "updatemessage.php",
            data: { id: messageId, message: editedContent },
            success: function(response) {
            console.log("Message modifié avec succès !");
            },
            error: function() {
            console.log("Erreur lors de l'enregistrement des modifications.");
            }
        });}
        //function pour supprimer un message
        function deleteMessage(messageId) {
        $.ajax({
            type: "POST",
            url: "delMessage.php",
            data: { id: messageId },
            success: function(response) {
            console.log("Message supprimé avec succès !");
            },
            error: function() {
            console.log("Erreur lors de la suppression du message.");
            }
        });
}
        //supprimer un message avec le boutton supprimer
      


        $(document).ready(function() {
  $(".receiver").click(function() {
    var div = $(this);
    var text = div.text();
    var input = $("<input type='text'>").val(text);

    div.empty().append(input);

    input.focus();
    input.blur(function() {
      var newText = $(this).val();
      div.empty().text(newText);
    });
  });
});

//create group

function creategroup(){
var name = document.querySelector('#group_name').value;
var description = document.querySelector('#descriptions').value;
$.ajax({
    type:'POST',
    url:'createroom.php',
    data: { room_name: name, description: description },
    success: function(data, textStatus, xhr) {
    // La requête a abouti avec succès
    var status = xhr.status; // Récupérer le statut HTTP de la réponse
    console.log('Statut de réponse : ' + status);
  },
  error: function(xhr, textStatus, errorThrown) {
    // Une erreur s'est produite lors de la requête
    var status = xhr.status; // Récupérer le statut HTTP de la réponse
    console.log('erreur');
  }

})};
var button=document.getElementById("creategroup");    
button.addEventListener("click", function() {
         creategroup();
        });

document.getElementById('groupmessage').addEventListener("click",()=>{
    $.ajax({
                 type: "GET",
                 url: "showgroup.php",
                 success: function(data) {
                    var getData = JSON.parse(data);
                    let ul = document.querySelector(".liste");
                    ul.innerHTML="";
                   
                     var html = "";
                    
                     for (var i = 0; i < getData.length; i++) {
                      
                        ul.innerHTML += "<li class='group' data-id="+ getData[i].id +" ><div class='circle_image'><img src='https://img.nrj.fr/EIZG0nl4nXzmTzHGUU7xvpfEq90=/800x450/smart/medias%2F2022%2F10%2F63401522e919e_6340152ebd63f.jpg' alt='profile'></div><div class='name_message ' ><p>"+getData[i].name+"</p><p>"+getData[i].description+"</p></div></li>";

                            } 
    $(".group").on("click", function() {
       
                                var id = $(this).data("id");
                                var conn = new WebSocket('ws://localhost:8080?room='+$(this).data("id"));
                                
            var groupid = $(this).data("id");
            sessionStorage.setItem("room", groupid);
    $.ajax({
                 type: "POST",
                 url: "getgroupmessage.php",
                 data: {room: groupid},
                 beforeSend: function() {
                    console.log(groupid)
                  
                    $('#loading').show(); // Afficher l'élément de chargement
                    //cacher le input et le boutton envoyer
                    $("#input").removeClass("show");
                    $('#write').find(".messagecontentant").remove();


                },
                complete: function() {
                   
                    $('#loading').hide(); // Masquer l'élément de chargement
                    //afficher le boutton envoyer
                    $("#input").addClass("show");
                },
                 success: function(data) {
                     var html = "";
                     var getData = JSON.parse(data);
                     for (var i = 0; i < getData.length; i++) {
                         //verifier si le message est de l'utilisateur ou de l'autre
                            if (getData[i].sender_name == "<?php echo $_SESSION['name']; ?>") {
                                //ecrire lheure sans les secondes dans la variable time
                               
                                //laisser que les minutes et les heures
                                
                               
                                html += "<div  class=' recever_box messagecontentant'><div class='row'><div class='circle_image'><img src='https://img.nrj.fr/EIZG0nl4nXzmTzHGUU7xvpfEq90=/800x450/smart/medias%2F2022%2F10%2F63401522e919e_6340152ebd63f.jpg' alt='profile'></div><div class='receiver bullemessage draggableElement' id="+getData[i].id+" data-id="+getData[i].id+"  ><p> " + getData[i].message + "</p></div></div><div class='time'>"+getData[i].created_at+"</div></div>";
                               drag();
                               option();

                            } else{
                                
                                //laisser que les minutes et les heures
                                
                                html += "<div  class='sender_box messagecontentant'><div class='row_not_reverse'><div class='circle_image'><img src='https://img.nrj.fr/EIZG0nl4nXzmTzHGUU7xvpfEq90=/800x450/smart/medias%2F2022%2F10%2F63401522e919e_6340152ebd63f.jpg' alt='profile'></div><div class='sender bullemessage draggableElementleft' id="+getData[i].id+" data-id="+getData[i].id+" ><p>" + getData[i].message + "</p></div></div><div class='time'>"+getData[i].created_at+"</div></div>";
                                dragleft();
                                option();
                                
                            }
                            

                     }
                    
                     jQuery("#write").append(html);
                     write();
                     scrollContainer.scrollTop = scrollContainer.scrollHeight;
                 }

    })
         conn.onmessage = function(e) {
            var data = JSON.parse(e.data);
            var id = data.id;
            var html = "<div id="+id+" data-id="+id+" class='sender_box messagecontentant' ><div class='row_not_reverse'><div class='circle_image'><img src='https://img.nrj.fr/EIZG0nl4nXzmTzHGUU7xvpfEq90=/800x450/smart/medias%2F2022%2F10%2F63401522e919e_6340152ebd63f.jpg' alt='profile'></div><div class='sender bullemessage draggableElementleft'><p>" + data.msg + "</p></div></div><div class='time'>"+data.time+"</div></div>";
            dragleft();
            write();
            jQuery("#write").append(html);
          
        };
  
});}
                    
                    
                    
                    
                 }
             );
             
        
});
jQuery("#submit").click(function() {
           console.log(sessionStorage.getItem("room"));
           var msg = $("#message").val();
           var room = sessionStorage.getItem("room");
           var name = 3;
           var hour = new Date().getHours();
           var minute = new Date().getMinutes();
           var time = hour + ":" + minute;
           var content = {
               msg: msg,
               room: room,
               name: name,
               time: time
           };
           
           $.ajax({
               type: "POST",
               url: "saveMessage.php",
               data: {msg: msg, name: name, room: room, time: time },
               success: function(data) {
                   var data = JSON.parse(data);
                   console.log(data);
                   //remplacer le id temporaire par le id de la base de donnée
                   var id = data.id;
                   var temporaire_id = document.getElementById("temporaire_id");
                   temporaire_id.id = id;
                   temporaire_id.dataset.id = id;
               
                   
               }
              
         
           });
           conn.send(JSON.stringify(content));
           var html = "<div id='temporaire_id'  class='recever_box messagecontentant'><div class='row'><div class='circle_image'><img src='https://img.nrj.fr/EIZG0nl4nXzmTzHGUU7xvpfEq90=/800x450/smart/medias%2F2022%2F10%2F63401522e919e_6340152ebd63f.jpg' alt='profile'></div><div class='draggableElement receiver  bullemessage' data-id='temporaire_id'><p>" + msg + "</p></div></div><div class='time'>"+time+"</div></div>";
           drag();
           option();
           write();
          jQuery("#write").append(html);
          scrollContainer.scrollTop = scrollContainer.scrollHeight;
          jQuery("#message").val("");
           
        
           

       });
       conn.onopen = function(e) {
        
            var id= sessionStorage.getItem("room");
            //recuperer les messages de la room
             $.ajax({
                 type: "GET",
                 url: "getMessage.php",
                 data: {room:id  },
                 beforeSend: function() {
                    $('#loading').show(); // Afficher l'élément de chargement
                    //cacher le input et le boutton envoyer
                    $("#input").removeClass("show");


                },
                complete: function() {
                    $('#loading').hide(); // Masquer l'élément de chargement
                    //afficher le boutton envoyer
                    $("#input").addClass("show");
                },
                 success: function(data) {
                     var html = "";
                     var getData = JSON.parse(data);
                     for (var i = 0; i < getData.length; i++) {
                         //verifier si le message est de l'utilisateur ou de l'autre
                            if (getData[i].sender_name == "<?php echo $_SESSION['name']; ?>") {
                                //ecrire lheure sans les secondes dans la variable time
                                var time = getData[i].date;
                                //laisser que les minutes et les heures
                                time = time.substring(0, time.length - 3);
                               
                                html += "<div  class=' recever_box messagecontentant'><div class='row'><div class='circle_image'><img src='https://img.nrj.fr/EIZG0nl4nXzmTzHGUU7xvpfEq90=/800x450/smart/medias%2F2022%2F10%2F63401522e919e_6340152ebd63f.jpg' alt='profile'></div><div class='receiver bullemessage draggableElement' id="+getData[i].id+" data-id="+getData[i].id+"  ><p> " + getData[i].message + "</p></div></div><div class='time'>"+time+"</div></div>";
                               drag();
                               option();
                               

                            } else{
                                var time = getData[i].date;
                                //laisser que les minutes et les heures
                                time = time.substring(0, time.length - 3);
                                html += "<div  class='sender_box messagecontentant'><div class='row_not_reverse'><div class='circle_image'><img src='https://img.nrj.fr/EIZG0nl4nXzmTzHGUU7xvpfEq90=/800x450/smart/medias%2F2022%2F10%2F63401522e919e_6340152ebd63f.jpg' alt='profile'></div><div class='sender bullemessage draggableElementleft' id="+getData[i].id+" data-id="+getData[i].id+" ><p>" + getData[i].message + "</p></div></div><div class='time'>"+time+"</div></div>";
                                dragleft();
                                option();
                                
                            }
                            

                     }
                    
                     jQuery("#write").append(html);
                     write();
                     scrollContainer.scrollTop = scrollContainer.scrollHeight;
                 }
             });
            console.log("Connection established!");
            


        };
//function pour afficher le message des groups


document.getElementById('privés').addEventListener("click",()=>{
    $.ajax({
                 type: "GET",
                 url: "getfriend.php",
                 success: function(data) {
                    var getData = JSON.parse(data);
                    let ul = document.querySelector(".liste");
                    ul.innerHTML="";
                   
                     var html = "";
                    
                     for (var i = 0; i < getData.length; i++) {
                      
                        ul.innerHTML += "<li class='privatechat' data-id="+ getData[i][0].id +" ><div class='circle_image'><img src='https://img.nrj.fr/EIZG0nl4nXzmTzHGUU7xvpfEq90=/800x450/smart/medias%2F2022%2F10%2F63401522e919e_6340152ebd63f.jpg' alt='profile'></div><div class='name_message ' ><p>"+getData[i][0].username+"</p><p></p></div></li>";

                            } 
    $(".privatechat").on("click", function() {
       
                                var id = $(this).data("id");
                                var conn = new WebSocket('ws://localhost:8080?room='+$(this).data("id"));
                                
            var friendid = $(this).data("id");
            sessionStorage.setItem("room", friendid);
    $.ajax({
                 type: "POST",
                 url: "getprivatemessage.php",
                 data: {friend: friendid},
                 beforeSend: function() {
                    console.log(friendid)
                  
                    $('#loading').show(); // Afficher l'élément de chargement
                    //cacher le input et le boutton envoyer
                    $("#input").removeClass("show");
                    $('#write').find(".messagecontentant").remove();


                },
                complete: function() {
                   
                    $('#loading').hide(); // Masquer l'élément de chargement
                    //afficher le boutton envoyer
                    $("#input").addClass("show");
                },
                 success: function(data) {
                     var html = "";
                     var getData = JSON.parse(data);
                     for (var i = 0; i < getData.length; i++) {
                         //verifier si le message est de l'utilisateur ou de l'autre
                            if (getData[i].sender_id == "<?php echo $_SESSION['id']; ?>") {
                                //ecrire lheure sans les secondes dans la variable time
                               
                                //laisser que les minutes et les heures
                                
                               
                                html += "<div  class=' recever_box messagecontentant'><div class='row'><div class='circle_image'><img src='https://img.nrj.fr/EIZG0nl4nXzmTzHGUU7xvpfEq90=/800x450/smart/medias%2F2022%2F10%2F63401522e919e_6340152ebd63f.jpg' alt='profile'></div><div class='receiver bullemessage draggableElement' id="+getData[i].id+" data-id="+getData[i].id+"  ><p> " + getData[i].message + "</p></div></div><div class='time'>"+getData[i].created_at+"</div></div>";
                               drag();
                               option();

                            } else{
                                
                                //laisser que les minutes et les heures
                                
                                html += "<div  class='sender_box messagecontentant'><div class='row_not_reverse'><div class='circle_image'><img src='https://img.nrj.fr/EIZG0nl4nXzmTzHGUU7xvpfEq90=/800x450/smart/medias%2F2022%2F10%2F63401522e919e_6340152ebd63f.jpg' alt='profile'></div><div class='sender bullemessage draggableElementleft' id="+getData[i].id+" data-id="+getData[i].id+" ><p>" + getData[i].message + "</p></div></div><div class='time'>"+getData[i].created_at+"</div></div>";
                                dragleft();
                                option();
                                
                            }
                            

                     }
                    
                     jQuery("#write").append(html);
                     write();
                     scrollContainer.scrollTop = scrollContainer.scrollHeight;
                 }

    })
         conn.onmessage = function(e) {
            var data = JSON.parse(e.data);
            var id = data.id;
            var html = "<div id="+id+" data-id="+id+" class='sender_box messagecontentant' ><div class='row_not_reverse'><div class='circle_image'><img src='https://img.nrj.fr/EIZG0nl4nXzmTzHGUU7xvpfEq90=/800x450/smart/medias%2F2022%2F10%2F63401522e919e_6340152ebd63f.jpg' alt='profile'></div><div class='sender bullemessage draggableElementleft'><p>" + data.msg + "</p></div></div><div class='time'>"+data.time+"</div></div>";
            dragleft();
            write();
            jQuery("#write").append(html);
          
        };
  
});}
                    
                    
                    
                    
                 }
             );
             
        
});

         

       
</script>



</html>