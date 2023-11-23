<?php
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");

header("Access-Control-Allow-Credentials: true");

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
?>
