<?php

header("Access-Control-Allow-Origin: https://front.shpp");
header('Access-Control-Max-Age: 5');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    exit(0);
}

?>