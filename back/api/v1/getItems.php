<?php 

$request = $_SERVER[REQUEST_METHOD];

if ($request === "GET") {
    $data = file_get_contents("data.json");
    $data = json_decode($data, true);
    $output = [
        "items" => $data,
    ];
    echo json_encode($output);
} else {
    echo http_response_code(400);
}

