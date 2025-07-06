<?php

namespace Src\dao;

use PDO;
use Src\model\CaseCrypto;

final class CaseCryptoDAO extends DAO
{
    private PDO $dao;

    public function __construct()
    {
        $this->dao = $this->getConnect();
    }

    public function createCase(CaseCrypto $model): ?CaseCrypto
    {
        $stmt = $this->dao->prepare('INSERT INTO casecrypto (user_id) values (:user_id)');
        $stmt->bindValue(':user_id', $model->getUserId());
        $result = $stmt->execute();

        if (!$result) {
            return null;
        }

        $model->setId($this->dao->lastInsertId());
        return $model;
    }

    public function getCaseByUserId(int $id): ?CaseCrypto
    {
        $stmt = $this->dao->prepare('SELECT * FROM casecrypto WHERE user_id = :user_id');
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
