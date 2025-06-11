<?php

namespace projeto\controller;

use Exception;
use projeto\model\User;

final class UserController
{

    public static function login(): void
    {
        require_once "../view/login.php";
        exit;
    }

    public static function register(): void
    {   
        $error = '';
        try {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                $name = trim(htmlspecialchars(filter_input(INPUT_POST, 'name'), ENT_QUOTES));
                $lastName = trim(htmlspecialchars(filter_input(INPUT_POST, 'lastName'), ENT_QUOTES));
                $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
                $password = trim(filter_input(INPUT_POST, 'password'));

                if(empty($name) || empty($lastName) || empty($email) || empty($password)) {
                    throw new Exception("All fields must be filled in");
                }

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("Incorrect e-maill");
                }

                $models = new User($name, $lastName, $email, $password);
                
                if(!$models->save()) {
                    throw new Exception("Error cadaste new user or user is exists");
                }

                header('Location: /login');
                exit;
            }

        } catch(Exception $e) {
            $error = $e->getMessage();
        }

        require_once "../view/register.php";
        exit;
    }
}
