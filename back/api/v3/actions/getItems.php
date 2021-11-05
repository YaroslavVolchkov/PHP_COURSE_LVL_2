<?php

require_once('src/connect_db.php');
$user = $_COOKIE['key'];
$query = $connect->prepare("SELECT * FROM $user");

if ($query->execute()) {
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    $output = [];
    foreach ($data as $key => $value) {
        $output[] = [
            'id' => $value['id'],
            'text' => $value['text'],
            'checked' => (boolean) $value['checked']
        ];
    }

    echo json_encode(['items' => $output]);
} else {
    require_once('src/response.php');
    responseError('error request db', 500);
}

?>