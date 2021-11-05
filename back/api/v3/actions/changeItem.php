<?php

require('src/response.php');
$input = json_decode(file_get_contents('php://input'), true);

if (isValidInput($input)) {
    changeItem($input["id"], $input["text"], $input["checked"]);
} else {
    responseError("invalid input", 400);
}
    
/**
 * Function inside is requiring connect to databse, variable with connection is '$connect'
*/
function changeItem(int $id, string $text, int $checked) {
    require_once('src/connect_db.php');
    $user = $_COOKIE['key'];
    $query = $connect->prepare("UPDATE `$user` SET text = :text, checked = :checked WHERE id = :id");
    
    if ($query->execute(['text' => $text, 'checked' => $checked, 'id' => $id])) {
        responseOk();
    } else {
        responseError($connect->error, 500);
    }
}

function isValidInput($input) {
    return isset($input["id"]) && isset($input["text"]) && isset($input["checked"]) &&
    count($input["id"]) > 0 && count($input["text"]) > 0 && count($input["checked"]) > 0;
}
?>