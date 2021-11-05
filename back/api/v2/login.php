<?php
session_start();
require_once('cors.php');
require("response.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input["login"]) && isset($input["pass"])) {
        authUser($input["login"], $input["pass"]);
    } else {
        responseError("is invalid data", 500);
    }
} else {
    responseError("invalid request method", 500);
}


function authUser($login, $pass) {
    require_once('connect_db.php');
    $sql = "SELECT id, username, password FROM users WHERE username = '$login'";

    if ($user = $connect->query($sql)) {
        $user = $user->fetch_array();
        
        if (password_verify($pass, $user["password"])) {
            $_SESSION[$user["username"]] = true;
            setcookie("key", $user["username"]);
            responseOk();
        } else {
            responseError("wrong password", 400);
        }
    
    } else {
        responseError($connect->error, 500);
    }
    $connect->close();
}

?>