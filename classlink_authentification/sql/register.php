<?php

    require '../../classlink_app/inc/pdo.php';

    $json = file_get_contents('php://input');
    $data = json_decode($json,true);

    $username = $data["username"];
    $age = $data ['age'];
    $password = $data["password"];
    $first_name = $data["first_name"];
    $last_name = $data['last_name'];
    $mail = $data["mail"];
    $gender = $data["gender"];
    $question = $data["question"];
    $response = $data["answer"];

    $requete0 = $auth_pdo->prepare('
    SELECT * FROM users 
    WHERE username = :username
    ');

    $requete0->execute([
        ':username' => $username
     ]);

    $result = $requete0->fetch(PDO::FETCH_ASSOC);

    if(!$result){
            $request_register = $auth_pdo->prepare("
            INSERT INTO users (username,password,first_name,last_name,mail,birth_date,gender,question,response)
            VALUES (:username,:password,:first_name,:last_name,:mail,:age,:gender,:question,:response);
            ");

            $request_register->execute([
                ':username'=>$username,
                ':password'=>$password,
                ':first_name'=>$first_name,
                ':last_name'=>$last_name,
                ':mail'=>$mail,
                ':age'=>$age,
                ':gender'=>$gender,
                ':question'=>$question,
                ':response'=>$response
            ]);

            $request_register = $app_pdo->prepare("
            INSERT INTO profiles ('id', 'pp_image') VALUES (3, NULL);
            ");
            $request_register->execute();
            
            $data = [
                'statut' => "Succès",
                'message' => 'Inscription réussite'
            ];
            $json = json_encode($data);
            echo $json ;
            exit();
        }
        else{
            $data = array(
                'statut' => "Erreur",
                'message' => 'utilisateur déjà existant'
            );
            $json = json_encode($data);
            echo $json;
            exit();
        }
        
        
        $json = json_encode($data);
        echo $json;
        exit();
    

    print_r($data);