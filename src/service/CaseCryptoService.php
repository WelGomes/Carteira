<?php

namespace Src\service;

use Src\dao\CaseCryptoDAO;
use Src\dao\DAO;
use Src\exception\CaseCryptoException;
use Src\model\CaseCrypto;

final class CaseCryptoService 
{
    private CaseCryptoDAO $CaseCryptoDAO;

    public function __construct()
    {
        $this->CaseCryptoDAO = new CaseCryptoDAO();
    }

    public function createCase(CaseCrypto $model): CaseCrypto
    {
        $model = $this->CaseCryptoDAO->createCase($model);

        if (empty($model)) {
            throw new CaseCryptoException("Error registering Case in the database");
        }

        return $model;
    }

    public function getCaseByUserId(int $id): CaseCrypto
    {
        $model = $this->CaseCryptoDAO->getCaseByUserId($id);

        if (empty($model)) {
            throw new CaseCryptoException("Case not found for user.");
        }

        return $model;
    }
}
