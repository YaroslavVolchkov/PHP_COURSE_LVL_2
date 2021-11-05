<?php

$request = $_SERVER["REQUEST_METHOD"];

if ($request === "POST") {
    $inputItem = file_get_contents('php://input');
    $inputItem = json_decode($inputItem, true);

    if ($inputItem !== null) {
        putNewItem($inputItem);
    } else {
        echo http_response_code(404);
    }
} else {
    echo http_response_code(400);
}

function putNewItem($newItem) {
    $data = file_get_contents("data.json");
    $data = json_decode($data, true);
    $id = file_get_contents("id.json");
    $id = json_decode($id, true);

    $data[] = array(
        "id" => $id["id"],
        "text" => $newItem["text"],
        "checked" => false,
    );
    
    file_put_contents("data.json", json_encode($data));
    echo json_encode($id);
    
    $id["id"]++;
    file_put_contents("id.json", json_encode($id));
}
?>
