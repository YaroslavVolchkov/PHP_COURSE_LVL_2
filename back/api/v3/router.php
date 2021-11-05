<?php

session_start();

header("Access-Control-Allow-Origin: https://front.shpp");
header('Access-Control-Max-Age: 5');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    exit(0);
}

$query = explode("=", $_SERVER['QUERY_STRING']);
$request = $query[1];


if ($request === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('actions/register.php');

} else if ($request === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('actions/login.php');

} else if ($request === 'logout' && $_SERVER['REQUEST_METHOD'] === 'POST' 
        && $_SESSION[$_COOKIE['key']]) {
    require_once('actions/logout.php');

} else if ($request === 'getItems' && $_SERVER['REQUEST_METHOD'] === 'GET' 
        && $_SESSION[$_COOKIE['key']]) {
    require_once('actions/getItems.php');
    
} else if ($request === 'addItem' && $_SERVER['REQUEST_METHOD'] === 'POST' 
        && $_SESSION[$_COOKIE['key']]) {
    require_once('actions/addItem.php');

} else if ($request === 'changeItem' && $_SERVER['REQUEST_METHOD'] === 'PUT' 
        && $_SESSION[$_COOKIE['key']]) {
    require_once('actions/changeItem.php');

} else if ($request === 'deleteItem' && $_SERVER['REQUEST_METHOD'] === 'DELETE' 
        && $_SESSION[$_COOKIE['key']]) {
    require_once('actions/deleteItem.php');

} else {
    require_once('src/response.php');
    responseError("bad request", 400);
}

?>