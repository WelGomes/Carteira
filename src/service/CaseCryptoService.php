<?php

namespace projeto\src\service;

use Exception;
use projeto\src\dao\CaseCryptoDAO;
use projeto\src\model\CaseCrypto;

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
}
