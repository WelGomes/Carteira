<?php

namespace src\dao;

use PDO;
use src\model\Coin;

final class CoinDAO extends DAO
{
    private PDO $dao;

    public function __construct()
    {
        $this->dao = $this->getConnect();
    }

    public function save(Coin $model): ?Coin
    {
        return empty($this->getCoinByName($model->getName(), $model->getCaseId())) ? $this->register($model) : $this->updateCoin($model);
    }

    public function register(Coin $model): ?Coin
    {
        $stmt = $this->dao->prepare('INSERT INTO coin (symbol, name, image, price, quantity, case_id) VALUES (:symbol, :name, :image, :price, :quantity, :case_id)');
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

        $model->setId($this->dao->lastInsertId());

        return $model;
    }

    public function getCoins(int $userId): ?array
    {
        $stmt = $this->dao->prepare('SELECT * FROM coin WHERE case_id = :case_id');
        $stmt->bindValue(':case_id', $userId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        return array_map(function (array $model) {
            $coin = new Coin(
                symbol: $model['symbol'],
                name: $model['name'],
                image: $model['image'],
                price: $model['price'],
                quantity: $model['quantity'],
                caseId: $model['case_id'],
            );
            $coin->setId($model['id']);
            return $coin;
        }, $result);
    }

    public function getCoinByName(string $name, int $caseId): ?Coin
    {
        $stmt = $this->dao->prepare('SELECT * FROM coin WHERE name = :name AND case_id = :case_id');
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
        $stmt = $this->dao->prepare('UPDATE coin SET quantity = :quantity WHERE name = :name AND case_id = :case_id');
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
        $stmt = $this->dao->prepare('DELETE FROM coin WHERE name = :name');
        $stmt->bindValue(':name', $model->getName());
        $result = $stmt->execute();

        if (!$result) {
            return false;
        }

        return true;
    }
}
