<?php
    // if (isset($_POST['submit']) && isset($_FILES['file'])) {
    //     echo "Hello";
    //     $img_name = $_FILES['file']['name'];
    //     $img_size = $_FILES['file']['size'];
    //     $tmp_name = $_FILES['file']['tmp_name'];
    //     $error = $_FILES['file']['error'];
    //     $img_ex =  pathinfo($img_name, PATHINFO_EXTENSION);
    //     $img_ex_lc = strtolower($img_ex);

    //     $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
    //     $img_upload_path = 'uploads/'. $new_img_name;
    //     move_uploaded_file($tmp_name,$img_upload_path);
    //     print_r($_FILES['file']);
    if (isset($_POST['submit']) && isset($_FILES['file'])) {
        echo "Hello";
        $img_name = $_FILES['file']['name'];
        $img_size = $_FILES['file']['size'];
        $tmp_name = $_FILES['file']['tmp_name'];
        $error = $_FILES['file']['error'];
        $img_ex =  pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);

        $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
        $img_upload_path = 'uploads/'. $new_img_name;
        move_uploaded_file($tmp_name,$img_upload_path);
        print_r($_FILES['file']);
        echo $new_img_name;




        ?>
        
        
        
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        <body>
            <img src="<?= $tmp_name ?>" alt="">
        </body>
        </html><?php }
?> 
