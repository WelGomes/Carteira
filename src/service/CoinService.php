<?php

namespace src\service;

use src\dao\CoinDAO;
use src\exception\CoinException;
use src\model\Coin;

final class CoinService
{
    private CoinDAO $CoinDAO;

    public function __construct()
    {
        $this->CoinDAO = new CoinDAO();
    }

    public function register(string $button, Coin $model): mixed
    {
        switch ($button) {
            case 'add':
                return $this->save(model: $model, isSale: false);
                break;

            case 'sale':
                $coins = $this->getCoins($model->getCaseId());

                foreach ($coins as $key => $value) {
                    if ($value->getName() === $model->getName()) {
                        if($model->getQuantity() > $value->getQuantity()) {
                            throw new CoinException("You cannot sell more than you own");
                        }
                        $valueQuantity = $value->getQuantity() - $model->getQuantity();
                        $model->setQuantity($valueQuantity);
                    }
                }

                return $this->save(model: $model, isSale: true);
                break;

            case 'all':
                return $this->delete($model);
                break;

            case 'update':
                return $this->save($model, isSale: false);
                break;

            default:
                throw new CoinException("Invalid action: $button");
                break;
        }
    }

    public function save(Coin $model, bool $isSale): Coin
    {
        if (empty($model->getQuantity()) || $model->getQuantity() < 0.001) {
            throw new CoinException("Quantity field must be above 0.0001");
        }

        $modelExist = $this->CoinDAO->getCoinByName($model->getName(), $model->getCaseId());

        if (!empty($modelExist) && !$isSale) {
            $quantity = $modelExist->getQuantity() + $model->getQuantity();
            $model->setQuantity($quantity);
        }

        $model = $this->CoinDAO->save($model);

        if (empty($model)) {
            throw new CoinException("Error registering coin in the database");
        }

        return $model;
    }

    public function getCoins(int $caseId): ?array
    {
        return $this->CoinDAO->getCoins($caseId);
    }

    public function delete(Coin $model): bool
    {
        return $this->CoinDAO->deleteCoin($model) ?? throw new CoinException("Error in delete Coin");
    }
}
