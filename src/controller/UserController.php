<?php

namespace Welbert\Carteira\controller;

use Exception;
use Welbert\Carteira\exception\CaseCryptoException;
use Welbert\Carteira\exception\CoinsAPIException;
use Welbert\Carteira\exception\UserException;
use Welbert\Carteira\model\CaseCrypto;
use Welbert\Carteira\model\User;
use Welbert\Carteira\service\APIService;
use Welbert\Carteira\service\CaseCryptoService;
use Welbert\Carteira\service\UserService;

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
        try {
            if (!isset($_SESSION['user_log']) || !$_SESSION['user_log']) {
                header('Location: /');
            }

            $API = new APIService();
            $coin = $API->listCoin();
        } catch (CoinsAPIException $e) {
            $error = $e->getMessage();
        }
        require_once "../src/view/home.php";
        exit;
    }

    public static function login(): void
    {
        try {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $password = filter_input(INPUT_POST, 'password');

                $model = new User(email: $email, password: $password);
                $userService = new UserService();

                $model = $userService->login($model);

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
                $_SESSION['user_name'] = $model->getName();
                $_SESSION['id'] = $model->getId();

                header('Location: /home');
            }
        } catch (UserException $e) {
            $error = $e->getMessage();
        }
        require_once "../src/view/login.php";
        exit;
    }

    public static function register(): void
    {
        try {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $name = trim(htmlspecialchars(filter_input(INPUT_POST, 'name'), ENT_QUOTES));
                $lastName = trim(htmlspecialchars(filter_input(INPUT_POST, 'lastName'), ENT_QUOTES));
                $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
                $password = filter_input(INPUT_POST, 'password');

                $model = new User(
                    email: $email,
                    password: $password,
                    name: $name,
                    lastName: $lastName,
                );

                $userService = new UserService();
                $models = $userService->register($model);

                $caseCrypto = new CaseCrypto(userId: $model->getId());

                $caseCryptoService = new CaseCryptoService();
                $caseCryptoService->createCase($caseCrypto);

                header('Location: /');
                exit;
            }
        } catch (UserException $e) {
            $error = $e->getMessage();
        } catch (CaseCryptoException $e) {
            $error = $e->getMessage();
        }

        require_once "../src/view/register.php";
        exit;
    }
}
