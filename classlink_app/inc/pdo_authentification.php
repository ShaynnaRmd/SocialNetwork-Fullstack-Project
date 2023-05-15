<?php
    $app_engine = "mysql";
    $host_app = "containers-us-west-10.railway.app";

    $app_port = 7080; // port MAMP
    $app_bdd = "railway";
    $app_user = "root";
    $app_password = "QgBO6NR5hQb9QywJvWqw";

    $app_dsn = "$app_engine:host=$host_app:$app_port;dbname=$app_bdd";
    $app_pdo = new PDO($app_dsn, $app_user, $app_password);
