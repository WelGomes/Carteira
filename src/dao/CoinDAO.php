<?php

namespace projeto\src\dao;

use Exception;
use PDO;
use projeto\src\model\Coin;

final class CoinDAO extends DAO
{


    public function __construct()
    {
        parent::__construct();
    }

    public function save(Coin $model): ?Coin
    {
        $stmt = parent::$connect->prepare('INSERT INTO coin (symbol, name, image, price, quantity, case_id) VALUES (:symbol, :name, :image, :price, :quantity, :case_id)');
        $stmt->bindValue(':symbol', $model->getSymbol());
        $stmt->bindValue(':name', $model->getName());
        $stmt->bindValue(':image', $model->getImage());
        $stmt->bindValue(':price', $model->getPrice());
        $stmt->bindValue(':quantity', $model->getQuantity());
        $stmt->bindValue(':case_id', $model->getCaseId());
        $result = $stmt->execute();

        if (!$result) {
            return null;
        }

        $model->setId(parent::$connect->lastInsertId());

        return $model;
    }

    public function getCoin(string $name): ?Coin
    {
        $stmt = parent::$connect->prepare('SELECT * FROM coin WHERE name = :name');
        $stmt->bindValue(':name', $name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        $coin = new Coin(
            symbol: $result['symbol'],
            name: $result['name'],
            image: $result['image'],
            price: $result['price'],
            quantity: $result['quantity'],
            caseId: $result['case_id'],
        );

        $coin->setId($result['id']);

        return $coin;
    }
}
