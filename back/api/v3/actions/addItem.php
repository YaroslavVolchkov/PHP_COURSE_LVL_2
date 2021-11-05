<?php

require('src/response.php');
$input = json_decode(file_get_contents('php://input'), true);

if (isValidInput($input)) {
    putNewItem($input["text"]);
} else {
    responseError("invalid input", 400);
}

/**
 * Function inside is requiring connect to databse, variable with connection is '$connect'
*/
function putNewItem($text) {
    require_once('src/connect_db.php');
    $user = $_COOKIE["key"];
    $query = $connect->prepare("INSERT INTO `$user` (text, checked) VALUES (:text, FALSE)");
    
    if ($query->execute(['text' => $text])) {
        echo json_encode(["id" => $connect->lastInsertId()]);
    } else {
        responseError($connect->error, 500);
    }
    
}

function isValidInput($input) {
    return isset($input["text"]) && count($input["text"]) > 0;
}

?>
