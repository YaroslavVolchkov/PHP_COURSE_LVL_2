<?php

require_once('cors.php');
require('response.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input["login"]) && isset($input["pass"])) {
        addNewUser($input["login"], password_hash($input["pass"], PASSWORD_DEFAULT));
    } else {
        responseError("invalid input", 400);
    }
} else {
    responseError("invalid request method", 400);
}

/**
 * Function to add new user to dataBase
 * 
 * @param $login is a username
 * @param $pass is a password of current user
*/
function addNewUser($name, $pass) {
    $tableName = 'users';
    require_once('connect_db.php');
    
    //case if table with users is not exists
    $sql = "CREATE TABLE IF NOT EXISTS $tableName (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255), password VARCHAR(255))";
    if (!$connect->query($sql)) {
        responseError('error connection to db', 500);
    }
    
    $sql = "INSERT INTO users (username, password) VALUES ('$name', '$pass')";
    if ($connect->query($sql)) {
        addUserTable($name, $connect);
    } else {
        responseError($connect->error, 500);
    }
    $connect->close();
}

/**
 * Function to add new table with 'ToDo' for each user
 * 
 * @param $name is username
 * @param $connect is conection to dataBase
*/
function addUserTable($name, $connect) {
    $sql = "CREATE TABLE $name (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    text VARCHAR(255), checked TINYINT(1))";
    
    if ($connect->query($sql)) {
        responseOk();
    } else {
        responseError($connect->error, 500);
    }
}

?>