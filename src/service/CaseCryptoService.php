<?php

namespace Carteira\src\service;

use Carteira\src\dao\CaseCryptoDAO;
use Carteira\src\model\CaseCrypto;
use Exception;

final class CaseCryptoService
{
    private CaseCryptoDAO $dao;

    public function __construct()
    {
        $this->dao = new CaseCryptoDAO();
    }

    public function createCase(CaseCrypto $model): CaseCrypto
    {
        $model = $this->dao->createCase($model);

        if (empty($model)) {
            throw new Exception("Error registering Case in the database");
        }

        return $model;
    }

    public function getCaseByUserId(int $id): CaseCrypto
    {
        $model = $this->dao->getCaseByUserId($id);

        if(empty($model)) {
            throw new Exception("Case not found for user.");
        }

        return $model;
    }
}
