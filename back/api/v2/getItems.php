<?php

session_start();
require_once('cors.php');
require("response.php");

if ($_SERVER[REQUEST_METHOD] === "GET") {
    if ($_SESSION[$_COOKIE["key"]]) {
        getAllData();
    } else {
        responseError("not authorized", 500);
    }
} else {
    responseError("invalid method", 400);
}

/**
 * Function inside is requiring connect to databse, variable with connection is '$connect'
*/
function getAllData() {
    require_once ('connect_db.php');
    $user = $_COOKIE["key"];
    $sql = "SELECT * FROM $user";

    if ($result = $connect->query($sql)) {
        $temp = array();
            
        foreach($result as $row) {
            $temp[] = array(
                "id" => $row["id"],
                "text" => $row["text"],
                "checked" => (boolean) $row["checked"],
            );
        }
        echo json_encode(["items" => $temp]);
    } else {
        responseError($connect->error, 500);
    }
    $connect->close();
}

