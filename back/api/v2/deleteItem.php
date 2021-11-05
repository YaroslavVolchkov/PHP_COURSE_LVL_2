<?php

session_start();
require_once('cors.php');
require('response.php');

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    if ($_SESSION[$_COOKIE['key']]) {
        $input = json_decode(file_get_contents('php://input'), true);

        if (isset($input["id"])) {
            deleteItem($input["id"]);
        } else {
            responseError("invalid input", 400);
        }
    } else {
        responseError("not authorized", 400);
    }
} else {
    resposeError("invalid request method", 400);
}

/**
 * Function inside is requiring connect to databse, variable with connection is '$connect'
*/
function deleteItem($id) {
    require_once('connect_db.php');
    $user = $_COOKIE['key'];
    $sql = "DELETE FROM `$user` WHERE id = '$id'";
    
    if ($connect->query($sql)) {
        responseOk();
    } else {
        resposeError($connect->error, 500);
    }
    $connect->close();
}

?>