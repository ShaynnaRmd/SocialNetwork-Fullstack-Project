<?php
session_start();
if (isset($_POST['submit'])) {
	if(isset($_POST['name'])){
		$_SESSION['name'] = $_POST['name'];
	}
    if(isset($_POST['id'])){
        $_SESSION['id'] = $_POST['id'];
    }


}
if (isset($_SESSION['name'])) {
    header('Location: messagerie.php?name='.$_SESSION['name'].'&room=1');
}
?>
<form  method="post">
    <input type="text" name="name" placeholder="Enter your name">
    <input type="text" name="id">
    <input type="submit" name="submit" value="Enter">
   
</form>