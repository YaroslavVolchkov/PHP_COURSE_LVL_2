<?php

session_start();
require_once('cors.php');
require('response.php');

if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    if ($_SESSION[$_COOKIE['key']]) {
        $input = json_decode(file_get_contents('php://input'), true);

        if (isset($input["id"]) && isset($input["text"]) && isset($input["checked"])) {
            changeItem($input["id"], $input["text"], $input["checked"]);
        } else {
            responseError("invalid input", 400);
        }
    } else {
        responseError("not authorized", 500);
    }
} else {
    responseError("invalid request method", 400);
}

/**
 * Function inside is requiring connect to databse, variable with connection is '$connect'
*/
function changeItem(int $id, string $text, int $checked) {
    require_once('connect_db.php');
    $user = $_COOKIE['key'];
    $sql = "UPDATE `$user` SET text = '$text', checked = '$checked' WHERE id = '$id'";
    
    if ($connect->query($sql)) {
        responseOk();
    } else {
        responseError($connect->error, 500);
    }
    $connect->close();
}
?>