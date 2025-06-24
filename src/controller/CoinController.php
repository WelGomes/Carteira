<?php

namespace projeto\src\controller;

use Exception;
use projeto\src\model\Coin;
use projeto\src\service\CoinService;

final class CoinController
{

    public static function saveCoin(): void
    {
        $message = '';
        try {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $image = filter_input(INPUT_POST, 'image');
                $symbol = filter_input(INPUT_POST, 'symbol');
                $name = filter_input(INPUT_POST, 'name');
                $price = floatval(filter_input(INPUT_POST, 'price'));
                $quantity = floatval(filter_input(INPUT_POST, 'quantity'));

                $model = new Coin(
                    symbol: $symbol,
                    name: $name,
                    image: $image,
                    price: $price,
                    quantity: $quantity,
                    caseId: $_SESSION['id'],
                );

                $coinService = new CoinService();
                $model = $coinService->save($model);

                $message = "Crypto Registration Success";
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        echo "<script>
                alert('" . htmlspecialchars($message, ENT_QUOTES) . "');
                window.location.href='/home';
            </script>";
        exit;
    }

    public static function list(): void
    {
        require_once "../src/view/case.php";
    }
}
