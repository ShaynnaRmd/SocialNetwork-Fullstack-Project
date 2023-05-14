<?php

$app_engine = 'mysql';

$host = 'localhost';

$app_port = 3306;

$app_bdd = 'classlink_app';

$user = 'root';

$password_bdd = '';

$app_dsn = "$app_engine:host=$host:$app_port;dbname=$app_bdd";
$app_pdo = new PDO($app_dsn, $user, $password_bdd);