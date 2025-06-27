<?php

namespace projeto\src\dao;

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
        return empty($this->getCoinByName($model->getName(), $model->getCaseId())) ? $this->register($model) : $this->updateCoin($model);
    }

    public function register(Coin $model): ?Coin
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

    public function getCoins(int $userId): ?array
    {
        $stmt = parent::$connect->prepare('SELECT * FROM coin WHERE case_id = :case_id');
        $stmt->bindValue(':case_id', $userId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        $model = [];

        foreach ($result as $key => $value) {

            $coin = new Coin(
                symbol: $value['symbol'],
                name: $value['name'],
                image: $value['image'],
                price: $value['price'],
                quantity: $value['quantity'],
                caseId: $value['case_id'],
            );

            $coin->setId($value['id']);

            $model[] = $coin;
        }

        return $model;
    }

    public function getCoinByName(string $name, int $caseId): ?Coin
    {
        $stmt = parent::$connect->prepare('SELECT * FROM coin WHERE name = :name AND case_id = :case_id');
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':case_id', $caseId);
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

    public function updateCoin(Coin $model): ?Coin
    {
        $stmt = parent::$connect->prepare('UPDATE coin SET quantity = :quantity WHERE name = :name AND case_id = :case_id');
        $stmt->bindValue(':quantity', $model->getQuantity());
        $stmt->bindValue(':name', $model->getName());
        $stmt->bindValue(':case_id', $model->getCaseId());
        $result = $stmt->execute();

        if (!$result) {
            return null;
        }

        return $model;
    }

    public function deleteCoin(Coin $model): bool
    {
        $stmt = parent::$connect->prepare('DELETE FROM coin WHERE name = :name');
        $stmt->bindValue(':name', $model->getName());
        $result = $stmt->execute();

        if (!$result) {
            return false;
        }

        return true;
    }
}
