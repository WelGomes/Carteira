<?php

namespace Welbert\Carteira\controller;

use Exception;
use Welbert\Carteira\exception\CaseCryptoException;
use Welbert\Carteira\exception\CoinException;
use Welbert\Carteira\model\Coin;
use Welbert\Carteira\service\CaseCryptoService;
use Welbert\Carteira\service\CoinService;

final class CoinController
{

    public static function saveCoin(): void
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

                switch ($button) {
                    case 'add':
                        $model = $coinService->save(model: $model, isSale: false);
                        $page = '/home';
                        break;

                    case 'sale':
                        $coins = $coinService->getCoins($caseId->getId());

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
                        $model = $coinService->delete($model);
                        $page = '/case';
                        break;

                    case 'update':
                        $model = $coinService->save($model, false);
                        $page = '/case';
                        break;
                }

                $message = "Crypto Registration Success";
            }
        } catch (CaseCryptoException $e) {
            $message = $e->getMessage();
        } catch (CoinException $e) {
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
