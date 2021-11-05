<?php

/**
 * Pharams of database connection
*/

$host = 'localhost';
$db = 'todo';
$username = 'root';
$password = 'root';

try {
    $connect = new PDO("mysql:host=$host;dbname=$db", $username, $password);

} catch (PDOException $e) {
    require_once('respose.php');
    responseError($e->getMessage(), 500);
    exit(1);
}

?>
