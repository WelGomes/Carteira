<?php

namespace projeto\src\controller;

use Exception;
use projeto\src\model\CaseCrypto;
use projeto\src\model\User;
use projeto\src\service\APIService;
use projeto\src\service\CaseCryptoService;
use projeto\src\service\UserService;

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
        if ($_SESSION['user_log'] != true) {
            header('Location: /');
        }

        $API = new APIService();
        $coin = $API->listCoin();

        require_once "../src/view/home.php";
        exit;
    }

    public static function login(): void
    {
        $error = '';
        try {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $password = filter_input(INPUT_POST, 'password');
                
                $model = new User(email: $email, password: $password);
                $userService = new UserService();

                $userService->login($model);

                if (isset($_POST['save'])) {
                    setcookie(
                        'save_email',
                        $model->getEmail(),
                        time() + (60 * 60 * 24 * 30)
                    );
                } else {
                    setcookie(
                        'save_email',
                        $model->getEmail(),
                        time() - (60 * 60 * 24 * 30)
                    );
                }

                $_SESSION['user_log'] = true;
                header('Location: /home');
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
        require_once "../src/view/login.php";
        exit;
    }

    public static function register(): void
    {
        $error = '';
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $name = trim(htmlspecialchars(filter_input(INPUT_POST, 'name'), ENT_QUOTES));
                $lastName = trim(htmlspecialchars(filter_input(INPUT_POST, 'lastName'), ENT_QUOTES));
                $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
                $password = filter_input(INPUT_POST, 'password');

                $models = new User(
                    email: $email, 
                    password: $password, 
                    name: $name, 
                    lastName: $lastName,
                );

                $userService = new UserService();
                $models = $userService->register($models);
                
                $caseCrypto = new CaseCrypto(userId: $models->getId());
                
                $caseCryptoService = new CaseCryptoService();
                $caseCryptoService->createCase($caseCrypto);
                
                header('Location: /login');
                exit;
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        require_once "../src/view/register.php";
        exit;
    }
}
