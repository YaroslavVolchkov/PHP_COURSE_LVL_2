<?php

session_start();
require("src/response.php");
$input = json_decode(file_get_contents('php://input'), true);

if (isValidInput($input)) {
    authUser($input["login"], $input["pass"]);
} else {
    responseError("is invalid data", 500);
}

/**
 * Function to authorize user
 * 
 * @param login is username 
 * @param pass is a password
*/
function authUser($login, $pass) {
    require_once('src/connect_db.php');
    $query = $connect->prepare("SELECT username, password FROM users WHERE username =:login");
    if ($query->execute(['login' => $login])) {
        $currentUser = $query->fetch();
    
        if (password_verify($pass, $currentUser['password'])) {
            $_SESSION[$login] = true;
            setcookie("key", $login);
            responseOk();
        } else {
            responseError("wrong password", 400);
        }
    } else {
        responseError('error connection to db', 500);
    }
}

function isValidInput($input) {
    return isset($input["login"]) && isset($input["pass"]) &&
    count($input["login"]) > 0 && count($input["pass"]) > 0;
}

?>