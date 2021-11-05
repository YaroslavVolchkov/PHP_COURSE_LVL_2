<?php
$request = $_SERVER[REQUEST_METHOD];

if($request === "PUT") {
    changeItem();
} else {
    echo http_response_code(404);
}

function changeItem() {
    $input = file_get_contents('php://input');
    $input = json_decode($input, true);
    $data = file_get_contents("data.json", true);
    $data = json_decode($data, true);
    
    foreach ($data as $key => &$value) {
        if ($value["id"] === $input["id"]) {
            $value["checked"] = $input["checked"];

            if ($value["text"] !== $input["text"]) {
                $value["text"] = $input["text"];
            }
            $output = array(
                "ok" => $value["checked"],
            );
            echo json_encode($output);
        }
    }
    file_put_contents("data.json", json_encode($data));
}

?>