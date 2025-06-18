<?php

namespace projeto\src\dao;

use Exception;
use projeto\src\model\CaseCrypto;

final class CaseCryptoDAO extends DAO
{

    public function __construct()
    {
        parent::__construct();
    }


    public function createCase(CaseCrypto $model): CaseCrypto
    {
        $stmt = parent::$connect->prepare('INSERT INTO casecrypto (user_id) values (:user_id)');
        $stmt->bindValue(':user_id', $model->getUserId());
        $result = $stmt->execute();

        if (!$result) {
            throw new Exception("Error registering Case in the database");
        }

        $model->setId(parent::$connect->lastInsertId());
        return $model;
    }
}
