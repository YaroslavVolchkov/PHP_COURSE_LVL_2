<?php
$request = $_SERVER[REQUEST_METHOD];

if($request === "DELETE") {
    deleteItem();
} else {
    echo http_response_code(404);
}

function deleteItem() {
    $removingId = file_get_contents('php://input');
    $removingId = json_decode($removingId, true);
    $data = file_get_contents("data.json", true);
    $data = json_decode($data, true);

    foreach ($data as $key => $value) {
        if ($value["id"] === $removingId["id"]) {
            unset($data[$key]);
            $output = array(
                "ok" => true,
            );
            echo json_encode($output);
        }
    }
    file_put_contents("data.json", json_encode($data));
}

?>