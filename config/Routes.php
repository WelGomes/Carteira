<?php

namespace config;

use Exception;

abstract class Routes
{
    public static function load(string $class, string $method): void
    {
        try {
            $classController = "\\src\\controller\\{$class}";

            if (!class_exists($classController)) {
                throw new Exception("Class not exists {$classController}");
            }

            $classNew = new $classController();

            if (!method_exists($classNew, $method)) {
                throw new Exception("Method not exists");
            }

            $classNew->$method();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function routes(string $request, string $uri): callable
    {
        $routes =  [
            'POST' => [
                '/' => fn() =>  self::load('UserController', 'login'),
                '/register' => fn() => self::load('UserController', 'register'),
                '/home' => fn() => self::load('UserController', 'home'),
                '/close' => fn() => self::load('UserController', 'close'),
                '/case' => fn() => self::load('CoinController', 'saveCoin'),
            ],
            'GET' => [
                '/' => fn() =>  self::load('UserController', 'login'),
                '/register' => fn() => self::load('UserController', 'register'),
                '/home' => fn() => self::load('UserController', 'home'),
                '/close' => fn() => self::load('UserController', 'close'),
                '/case' => fn() => self::load('CoinController', 'list'),
            ]
        ];

        if(!array_key_exists($uri, $routes[$request])) {
            throw new Exception("Path not exists");
        }

        return $routes[$request][$uri];
    }
}