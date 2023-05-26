<?php
if(isset($_SESSION['token'])){
    $check = token_check($_SESSION["token"], $auth_pdo);
    if($check == 'false'){
        header('Location: ./connections/login.php');
    }
}elseif(!isset($_SESSION['token'])){
    header('Location: ./connections/login.php');
}

$requete = $app_pdo->prepare("
SELECT pp_image FROM profiles WHERE id = :id;
");
$requete->execute([
    ":id" => $_SESSION['id']
]);
$result = $requete->fetch(PDO::FETCH_ASSOC);
$path_img = 'http://localhost/SocialNetwork-Fullstack-Project/classlink_app/profiles/uploads/';
$dirimg = 'http://localhost/SocialNetwork-Fullstack-Project/assets/img/';

if($result){
    $pp_image = $result['pp_image'];
}else{
    $pp_image = 'default_pp.jpg';
}

?>

    <style>
        * {
    font-family: "new-hero", sans-serif;
    margin: 0;
}

body {
    display: grid;
    grid-template: 50px 100px 170px 150px 80px / 350px 1fr 300px;
    width: 100%;
    background-color: rgb(230, 230, 230);
    gap: 20px;
}

.header {
    background-color: #4F4789;
    grid-area: 1 / 1 / 1 / 4;
}

img {
    height: 30px;
    margin-top: 7px;
}

.logo {
    margin-left: 90px;
}

.input-box {
    position: relative;
    float: right;
    right: 59%;
    margin-top: 10px;
    height: 30px;
    max-width: 10px;
    width: 50%;
    border-radius: 7px;
    background-color: #fff;
    transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    cursor: pointer;
}

.input-box.open {
    max-width: 200px;
}

.input-box input {
    position: relative;
    height: 100%;
    width: 100%;
    padding: 0;
    outline: none;
    border: none;
    border-radius: 7px;
    transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.input-box.open input {
    padding: 0 15px 0 40px
}

.input-box .search {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 30px;
    background-color: #4F4789;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.search .search-icon {
    font-size: 30px;
    color: #ffffff;
    margin-right: 20px;
}

.input-box .close-icon {
    position: absolute;
    right: -80px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
    color: #fff;  
    opacity: 0;
    pointer-events: none;
    transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    z-index: 10;
}

.input-box.open .close-icon {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(-50%) rotate(180deg);
    z-index: 10;
}

.dropdown {
    z-index: 10;
	display: none;
	background: #fff;
	position: absolute;
	width: 200px;
	top: 47px;

    margin-left: 250px;
	border-top-left-radius: 0;
	border-top-right-radius: 0;
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.05), 
				0 0 2px rgba(0, 0, 0, 0.05),
				0 0 3px rgba(0, 0, 0, 0.05),
				0 0 4px rgba(0, 0, 0, 0.05), 
				0 0 5px rgba(0, 0, 0, 0.05), 
				0 0 4px rgba(0, 0, 0, 0.05), 
				0 0 5px rgba(0, 0, 0, 0.05)
}
.dropdown li {
	list-style: none;
	text-align: left;
}
.dropdown li a {
	display: block;
	padding: 10px;
	text-decoration: none;
	color: #000000;
	font-size: 16px;
	font-weight: 500;
}
.dropdown li a:hover {
	background: #eee;
}


.messages-icon {
    position: absolute;
    right: 80px;
    margin-top: 3px;
}

.notifications {
    position: absolute;
    right: 160px;
    margin-top: 3px;
}


.profile-icon-header, .tv-icon {
    position: relative;
    padding: 40px;
    left: 30%;
}

    </style>

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
        <a class="profile-icon-header" href="../profile2.php">
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