<?php

namespace Carteira\src\dao;

use Carteira\src\model\CaseCrypto;
use PDO;

final class CaseCryptoDAO extends DAO
{

    public function __construct()
    {
        parent::__construct();
    }

    public function createCase(CaseCrypto $model): ?CaseCrypto
    {
        $stmt = parent::$connect->prepare('INSERT INTO casecrypto (user_id) values (:user_id)');
        $stmt->bindValue(':user_id', $model->getUserId());
        $result = $stmt->execute();

        if (!$result) {
            return null;
        }

        $model->setId(parent::$connect->lastInsertId());
        return $model;
    }

    public function getCaseByUserId(int $id): ?CaseCrypto
    {
        $stmt = parent::$connect->prepare('SELECT * FROM casecrypto WHERE user_id = :user_id');
        $stmt->bindValue(':user_id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        $model = new CaseCrypto(userId: $result['user_id']);
        $model->setId($result['id']);

        return $model;
    }
}
