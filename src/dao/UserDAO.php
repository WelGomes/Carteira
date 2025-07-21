<?php

namespace src\dao;

use PDO;
use src\model\User;

final class UserDAO extends DAO
{

    private PDO $dao;

    public function __construct()
    {
        $this->dao = $this->getConnect();
    }

    public function save(User $model): ?User
    {
        $stmt = $this->dao->prepare('INSERT INTO user (name, lastName, email, password) VALUES (:name, :lastName, :email, :password)');
        $stmt->bindValue(':name', $model->getName());
        $stmt->bindValue(':lastName', $model->getLastName());
        $stmt->bindValue(':email', $model->getEmail());
        $stmt->bindValue(':password', password_hash($model->getPassword(), PASSWORD_ARGON2ID));
        $result = $stmt->execute();

        if (!$result) {
            return null;
        }

        $model->setId($this->dao->lastInsertId());
        return $model;
    }

    public function getUserByEmail(string $email): ?User
    {
        $stmt = $this->dao->prepare('SELECT * FROM user WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return new User(
            name: $result['name'],
            lastName: $result['lastName'],
            email: $email,
            password: $result['password'],
            id: $result['id']
        );
    }
}
