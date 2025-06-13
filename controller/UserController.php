<?php

namespace projeto\controller;

use Exception;
use projeto\model\User;

final class UserController
{

    public static function close(): void
    {
        session_destroy();
        header('Location: /');
        exit;
    }

    public static function home(): void
    {   
        if($_SESSION['user_log'] != true) {
            header('Location: /');
        }

        require_once "../view/home.php";
        exit;
    }

    public static function login(): void
    {   
        $error = '';
        try {

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $password = filter_input(INPUT_POST, 'password');
                
                if(empty($email) || empty($password)) {
                    throw new Exception("All fields must be filled in");
                }

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("Incorrect e-mail");
                }


                $model = new User(email: $email, password: $password);
                
                if(!$model->login()) {
                    throw new Exception("Error e-mail or password incorrect");
                }

                if(isset($_POST['save'])) {
                    setcookie(
                        'save_email',
                        $model->getEmail(),
                        time()+(60*60*24*30)
                    );
                } else {
                    setcookie(
                        'save_email',
                        $model->getEmail(),
                        time()-(60*60*24*30)
                    );
                }

                $_SESSION['user_log'] = true;
                header('Location: /home');
            }

        } catch(Exception $e) {
            $error = $e->getMessage();
        }
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
                $password = filter_input(INPUT_POST, 'password');

                if(empty($name) || empty($lastName) || empty($email) || empty($password)) {
                    throw new Exception("All fields must be filled in");
                }

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("Incorrect e-mail");
                }

                $models = new User(email: $email, password: $password, name: $name, lastName: $lastName,);
                
                if(!$models->register()) {
                    throw new Exception("Could not register user. Email might already be in use.");
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
