<?php

use config\Routes;

session_start();

//require_once '../config/autoload.php';
require_once '../vendor/autoload.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = $_SERVER['REQUEST_METHOD'];

try {

    if (!isset($request)) {
        throw new Exception("Requisiton is error or not exists");
    }

    $routes = Routes::routes(request: $request, uri: $uri)();
} catch (Exception $e) {
    http_response_code(404);
    echo $e->getMessage();
    exit;
}
