<?php

include 'Config/db.php';
include 'Routes/routes.php';

header("Content-Type: application/json");

try {
    Routes::handleRequest($pdo);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
