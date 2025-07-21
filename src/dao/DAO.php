<?php

namespace src\dao;

use PDO;
use PDOException;

abstract class DAO
{
    private string $host = "localhost";
    private string $dbname = "casecrypto";
    private string $user = "root";
    private string $password = "Root.123";
    private PDO $connect;

    protected function getConnect(): PDO
    {
        try {
            $this->connect = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->user, $this->password);
            return $this->connect;
        } catch (PDOException $e) {
            die("Error: Please try again later: {$e->getMessage()}");
        }
    }
}
