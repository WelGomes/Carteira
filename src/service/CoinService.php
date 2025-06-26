<?php

namespace projeto\src\service;

use Exception;
use projeto\src\dao\CoinDAO;
use projeto\src\model\Coin;

final class CoinService
{

    private CoinDAO $dao;

    public function __construct()
    {
        $this->dao = new CoinDAO();
    }

    public function save(Coin $model): Coin
    {

        if (empty($model->getQuantity()) || $model->getQuantity() < 0.001) {
            throw new Exception("Quantity field must be above 0.0001");
        }

        $modelExist = $this->dao->getCoin($model->getName());
        
        if(!empty($modelExist)) {
            $quantity = floatval($modelExist->getQuantity() + $model->getQuantity());
            $model->setQuantity($quantity);
        }
        
        $model = $this->dao->save($model);

        if (empty($model)) {
            throw new Exception("Error registering coin in the database");
        }
        
        return $model;
    }
}
