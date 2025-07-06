<?php

namespace Src\controller;

use Src\exception\CaseCryptoException;
use Src\exception\CoinException;
use Src\model\Coin;
use Src\service\CaseCryptoService;
use Src\service\CoinService;

final class CoinController
{
    public function saveCoin(): void
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $image = filter_input(INPUT_POST, 'image');
                $symbol = filter_input(INPUT_POST, 'symbol');
                $name = filter_input(INPUT_POST, 'name');
                $price = floatval(filter_input(INPUT_POST, 'price'));
                $quantity = floatval(filter_input(INPUT_POST, 'quantity'));
                $button = filter_input(INPUT_POST, 'action');

                $caseService = new CaseCryptoService();
                $caseId = $caseService->getCaseByUserId($_SESSION['id']);

                $model = new Coin(
                    symbol: $symbol,
                    name: $name,
                    image: $image,
                    price: $price,
                    quantity: $quantity,
                    caseId: $caseId->getId(),
                );

                $coinService = new CoinService();
                $coinService->register(button: $button, model: $model);

                $message = "Crypto Registration Success";
            }
        } catch (CaseCryptoException $e) {
            $message = $e->getMessage();
        } catch (CoinException $e) {
            $message = $e->getMessage();
        }

        echo "<script>
                alert('" . htmlspecialchars($message, ENT_QUOTES) . "');
                window.location.href='/case';
            </script>";
        exit;
    }

    public function list(): void
    {   
        try {
            $caseService = new CaseCryptoService();
            $caseId = $caseService->getCaseByUserId($_SESSION['id']);

            $coinService = new CoinService();
            $model = $coinService->getCoins($caseId->getId());

            $balance = 0;

            if (!empty($model)) {
                foreach ($model as $key => $value) {
                    $balance += $value->getPrice() * $value->getQuantity();
                }
            }
        } catch (CaseCryptoException $e) {
            $error = $e->getMessage();
        } catch (CoinException $e) {
            $error = $e->getMessage();
        }

        require_once "../src/view/case.php";
    }
}
