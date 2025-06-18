<?php

function load(string $class, string $method): void
{
    try {
        $classController = "\\projeto\\src\\controller\\{$class}";

        if (!class_exists($classController)) {
            throw new Exception("Class not exists $classController");
        }

        $classNew = new $classController();

        if (!method_exists($classNew, $method)) {
            throw new Exception("Method not exists");
        }

        $classNew::$method();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}


$routes = [
    'POST' => [
        '/' => fn() =>  load('UserController', 'login'),
        '/register' => fn() => load('UserController', 'register'),
        '/home' => fn() => load('UserController', 'home'),
        '/close' => fn() => load('UserController', 'close'),
    ],
    'GET' => [
        '/' => fn() =>  load('UserController', 'login'),
        '/register' => fn() => load('UserController', 'register'),
        '/home' => fn() => load('UserController', 'home'),
        '/close' => fn() => load('UserController', 'close'),
    ]
];
