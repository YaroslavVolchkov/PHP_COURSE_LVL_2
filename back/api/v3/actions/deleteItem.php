<?php

require('src/response.php');
$input = json_decode(file_get_contents('php://input'), true);

if (isValidInput($input)) {
    deleteItem($input["id"]);
} else {
    responseError("invalid input", 400);
}
    
/**
 * Function inside is requiring connect to databse, variable with connection is '$connect'
*/
function deleteItem($id) {
    require_once('src/connect_db.php');
    $user = $_COOKIE['key'];
    $query = $connect->prepare("DELETE FROM `$user` WHERE id = :id");

    if ($query->execute(['id' => $id])) {
        responseOk();
    } else {
        resposeError($connect->error, 500);
    }
    
}

function isValidInput($input) {
    return isset($input["id"]) && count($input["id"]) > 0;
}

?>