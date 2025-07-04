<?php

namespace Welbert\Carteira\service;

use Exception;
use Welbert\Carteira\dao\CaseCryptoDAO;
use Welbert\Carteira\exception\CaseCryptoException;
use Welbert\Carteira\model\CaseCrypto;

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
            throw new CaseCryptoException("Error registering Case in the database");
        }

        return $model;
    }

    public function getCaseByUserId(int $id): CaseCrypto
    {
        $model = $this->dao->getCaseByUserId($id);

        if(empty($model)) {
            throw new CaseCryptoException("Case not found for user.");
        }

        return $model;
    }
}
