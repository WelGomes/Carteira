<?php

namespace projeto\src\dao;

use Exception;
use PDO;
use projeto\src\model\User;

final class UserDAO extends DAO
{

    public function __construct()
    {
        parent::__construct();
    }

    public function save(User $model): ?User
    {
        $stmt = parent::$connect->prepare('INSERT INTO user (name, lastName, email, password) VALUES (:name, :lastName, :email, :password)');
        $stmt->bindValue(':name', $model->getName());
        $stmt->bindValue(':lastName', $model->getLastName());
        $stmt->bindValue(':email', $model->getEmail());
        $stmt->bindValue(':password', password_hash($model->getPassword(), PASSWORD_ARGON2ID));
        $result = $stmt->execute();

        if (!$result) {
            return null;
        }

        $model->setId(parent::$connect->lastInsertId());
        return $model;
    }

    public function getUserByEmail(string $email): ?User
    {

        $stmt = parent::$connect->prepare('SELECT * FROM user WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return $user = new User(
            name: $result['name'],
            lastName: $result['lastName'],
            email: $result['email'],
            password: $result['password'],
            id: $result['id']
        );
    }
}
