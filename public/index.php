<?php

session_start();

require_once '../config/autoload.php';
require_once '../config/routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = $_SERVER['REQUEST_METHOD'];

try {

    if (!isset($request)) {
        throw new Exception("Requisiton is error or not exists");
    }

    if (!array_key_exists($uri, $routes[$request])) {
        throw new Exception("Path not exists");
    }

    $routes[$request][$uri]();
} catch (Exception $e) {
    http_response_code(404);
    $e->getMessage();
    exit;
}
