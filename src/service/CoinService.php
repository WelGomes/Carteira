<?php

namespace Welbert\Carteira\service;

use Exception;
use Welbert\Carteira\dao\CoinDAO;
use Welbert\Carteira\exception\CoinException;
use Welbert\Carteira\model\Coin;

final class CoinService
{

    private CoinDAO $dao;

    public function __construct()
    {
        $this->dao = new CoinDAO();
    }

    public function save(Coin $model, bool $isSale): Coin
    {

        if (empty($model->getQuantity()) || $model->getQuantity() < 0.001) {
            throw new CoinException("Quantity field must be above 0.0001");
        }

        $modelExist = $this->dao->getCoinByName($model->getName(), $model->getCaseId());

        if (!empty($modelExist) && !$isSale) {
            $quantity = $modelExist->getQuantity() + $model->getQuantity();
            $model->setQuantity($quantity);
        }

        $model = $this->dao->save($model);

        if (empty($model)) {
            throw new CoinException("Error registering coin in the database");
        }

        return $model;
    }

    public function getCoins(int $caseId): ?array
    {
        return $this->dao->getCoins($caseId);
    }

    public function delete(Coin $model): bool
    {
        return $this->dao->deleteCoin($model) ?? throw new CoinException("Error in delete Coin");
    }
}
