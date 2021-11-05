<?php

session_start();
require_once('cors.php');
require('response.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_SESSION[$_COOKIE['key']]) {
        $input = json_decode(file_get_contents('php://input'), true);
    
        if (isset($input["text"])) {
            putNewItem($input["text"]);
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
function putNewItem($text) {
    require_once('connect_db.php');
    $user = $_COOKIE["key"];
    $sql = "INSERT INTO `$user` (text, checked) VALUES ('$text', FALSE)";
    
    if ($connect->query($sql)) {
        echo json_encode(["id" => $connect->insert_id]);
    } else {
        responseError($connect->error, 500);
    }
    $connect->close();
}

?>
