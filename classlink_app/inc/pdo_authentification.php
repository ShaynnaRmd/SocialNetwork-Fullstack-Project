<?php
    $auth_engine = "mysql";
    $host = "containers";

    $auth_port = 6741; // port MAMP
    $auth_bdd = "railway";
    $user = "root";
    $password_bdd = "uG7gyx2rT5a8Inw5FrNd";

    $auth_dsn = "$auth_engine:host=$host:$auth_port;dbname=$auth_bdd";
    $auth_pdo = new PDO($auth_dsn, $user, $password_bdd);

    $auth_engine = "mysql";
    $host = "containers-us-west-210.railway.app";

    $auth_port = 7469; // port MAMP
    $auth_bdd = "railway";
    $user = "root";
    $password_bdd = "ojBziPyDFfL28IGzqZXn";

    $auth_dsn = "$auth_engine:host=$host:$auth_port;dbname=$auth_bdd";
    $auth_pdo = new PDO($auth_dsn, $user, $password_bdd);
