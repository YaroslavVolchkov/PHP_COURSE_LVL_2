<?php

function responseOk() {
    echo json_encode(['ok' => true]);
}

function resposeError(string $message, int $statuscode) {
    echo json_encode(['error' => $message]);
    echo http_response_code($statuscode);
}

?>