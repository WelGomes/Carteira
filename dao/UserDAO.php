<?php

namespace projeto\dao;

use PDO;
use projeto\model\User;

final class UserDAO extends DAO
{

    public function __construct()
    {
        parent::__construct();
    }



    public function register(User $model): bool
    {
        $stmt = parent::$connect->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindValue(':email', $model->getEmail());
        $stmt->execute();

        if ($stmt->fetch()) {
            return false;
        }

        $stmt = parent::$connect->prepare('INSERT INTO users (name, lastName, email, password) VALUES (:name, :lastName, :email, :password)');
        $stmt->bindValue(':name', $model->getName());
        $stmt->bindValue(':lastName', $model->getLastName());
        $stmt->bindValue(':email', $model->getEmail());
        $stmt->bindValue(':password', password_hash($model->getPassword(), PASSWORD_ARGON2ID));
        $result = $stmt->execute();

        if ($result) {
            $model->setId(parent::$connect->lastInsertId());
        }

        return $result;
    }

    public function login(User $model): bool
    {
        $stmt = parent::$connect->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindValue(':email', $model->getEmail());
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return false;
        }

        return password_verify($model->getPassword(), $result['password']);
    }
}
