<?php
    require '../../classlink_app/inc/pdo.php';

    $json = file_get_contents('php://input'); // récupère les données brutes envoyées avec la requete POST et les assignent à $json
    $data = json_decode($json, true); // décode la chaine $json en un tableau associatif et l'assigne à $data ; l'argument 'true' specifie qu'on renvoie un tableau plutot qu'un objet
    $username = $data['username'];

    // if ("mimene" == $data['username']){
    //     $response_array = array(
    //             'message' => 'réussi'
    //         );
    //         $response = json_encode($response_array);
    //         echo $response;
    // }
    // $response_array = array(
    //     'username' => $username
    // );
    // $response = json_encode($response_array);
    // echo $response;
    
    // if ($data) {
    //     $response = array (
    //         'message' => "J'ai reçu quelque chose."
    //     );
    //     $json = json_encode($response);
    //     echo $json;
    // }

    $existing_user_request = $auth_pdo->prepare("
    SELECT * FROM users WHERE username = :username
    ");

    $existing_user_request->execute([
        ":username" => $username
    ]);

    $existing_user_result = $existing_user_request->fetch(PDO::FETCH_ASSOC);
    //var_dump($existing_user_result);

    if ($existing_user_result){
        $id = $existing_user_result['id'];
        $data = array(
            'statut' => 'Succès', 
            'id' => $id
        );

        $json = json_encode($data);
        echo $json;
        exit();

    }else{
        $data = array(
            'statut' => 'Erreur',
            'message' => 'Utilisateur inexistant'
        );

        $json = json_encode($data);
        echo $json;
        exit();
    }