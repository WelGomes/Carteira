<?php

namespace Welbert\Carteira\dao;

use PDO;

abstract class DAO
{

    protected static PDO $connect;

    public function __construct()
    {
        self::$connect = new PDO("mysql:host=localhost;dbname=casecrypto", 'root', 'Root.123');
    }
}
