<?php

/**
 * Default pharameters to connect database by using MAMP
*/
$host = 'localhost';
$username = 'root';
$password = 'root';
$dbName = 'todo';

$connect = new mysqli($host, $username, $password, $dbName);

if ($connect->connect_error) {
    echo json_encode(["error" => $connect->connect_error]);
}

?>