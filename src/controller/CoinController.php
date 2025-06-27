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
        $page = '';
        try {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $image = filter_input(INPUT_POST, 'image');
                $symbol = filter_input(INPUT_POST, 'symbol');
                $name = filter_input(INPUT_POST, 'name');
                $price = floatval(filter_input(INPUT_POST, 'price'));
                $quantity = floatval(filter_input(INPUT_POST, 'quantity'));
                $button = filter_input(INPUT_POST, 'action');

                $model = new Coin(
                    symbol: $symbol,
                    name: $name,
                    image: $image,
                    price: $price,
                    quantity: $quantity,
                    caseId: $_SESSION['id'],
                );

                switch ($button) {
                    case 'add':
                        $coinService = new CoinService();
                        $model = $coinService->save(model: $model, isSale: false);
                        $page = '/home';
                        break;

                    case 'sale':
                        $coinService = new CoinService();
                        $coins = $coinService->getCoins();

                        foreach ($coins as $key => $value) {
                            if ($value->getName() === $model->getName()) {
                                $valueQuantity = $value->getQuantity() - $model->getQuantity();
                                $model->setQuantity($valueQuantity);
                            }
                        }

                        $model = $coinService->save(model: $model, isSale: true);
                        $page = '/case';
                        break;

                    case 'all':
                        $coinService = new CoinService();
                        $model = $coinService->delete($model);
                        $page = '/case';
                        break;

                    case 'update':
                        $coinService = new CoinService();
                        $model = $coinService->save($model, false);
                        $page = '/case';
                        break;
                }

                $message = "Crypto Registration Success";
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        echo "<script>
                alert('" . htmlspecialchars($message, ENT_QUOTES) . "');
                window.location.href='$page';
            </script>";
        exit;
    }

    public static function list(): void
    {
        $coinService = new CoinService();
        $model = $coinService->getCoins();

        $balance = 0;

        if (!empty($model)) {
            foreach ($model as $key => $value) {
                $balance += $value->getPrice() * $value->getQuantity();
            }
        }

        require_once "../src/view/case.php";
    }
}
