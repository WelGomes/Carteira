<?php

namespace projeto\src\service;

use projeto\src\dao\CaseCryptoDAO;
use projeto\src\model\CaseCrypto;
use projeto\src\model\User;

final class CaseCryptoService
{
    private CaseCryptoDAO $dao;

    public function __construct()
    {
        $this->dao = new CaseCryptoDAO();
    }

    public function createCase(CaseCrypto $model): CaseCrypto
    {
        return $this->dao->createCase($model);
    }
}
