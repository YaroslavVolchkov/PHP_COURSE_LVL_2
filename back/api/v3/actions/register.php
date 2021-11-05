<?php

require('src/response.php');
$input = json_decode(file_get_contents('php://input'), true);

if (isValidInput($input)) {
    
    //add new user and hashing they password
    addNewUser($input["login"], password_hash($input["pass"], PASSWORD_DEFAULT));
} else {
    responseError("invalid input", 400);
}

/**
 * Function to add new user to dataBase
 * 
 * @param $login is a username
 * @param $pass is a password of current user
*/
function addNewUser($name, $pass) {
    $tableUsers = 'users';
    require_once('src/connect_db.php');
    
    //case if users table is not exist
    if (!tableExists($connect, $tableUsers)) {
        createUsersTable($connect, $tableUsers);
    }
    $query = $connect->prepare("INSERT INTO users (username, password) VALUES (:name, :pass)");
    
    if ($query->execute(['name' => $name, 'pass' => $pass])) {
        createUserTable($name, $connect);
    } else {
        responseError($connect->error, 500);
    }
}

/**
 * Function to add new table with 'ToDo' for each user
 * 
 * @param $name is username
 * @param $connect is object of conection to dataBase
*/
function createUserTable($name, $connect) {
    $query = $connect->prepare("CREATE TABLE $name (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    text VARCHAR(255), checked TINYINT(1))");
    
    if ($query->execute()) {
        responseOk();
    } else {
        responseError($connect->error, 500);
    }
}

function isValidInput($input) {
    return isset($input["login"]) && isset($input["pass"]) &&
    count($input["login"]) > 0 && count($input["pass"]) > 0;
}

/**
 * Function to check if table with users is it
 * 
 * @param connect is object of db connection
 * @param tableName is name of table
*/
function tableExists($connect, $tableName) {
    try {
        $result = $connect->query("SELECT 1 FROM $tableName LIMIT 1");
    } catch (Exception $e) {
        return FALSE;
    }
    return $result !== FALSE;
}

/**
 * Function to create a new user table
 * 
 * @param connect is object of db connection
 * @param tableName is name of table
*/
function createUsersTable($connect, $tableName) {
    $query = $connect->prepare("CREATE TABLE $tableName (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255), password VARCHAR(255))");

    if (!$query->execute()) {
        responseError('error connection to db', 500);
        exit(1);
    }
}
?>