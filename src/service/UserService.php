<?php

namespace projeto\src\service;

use Exception;
use projeto\src\dao\UserDAO;
use projeto\src\model\User;

final class UserService
{

    private UserDAO $dao;

    public function __construct()
    {
        $this->dao = new UserDAO();
    }

    public function register(User $model): User
    {

        if (
            empty($model->getName()) ||
            empty($model->getLastName()) ||
            empty($model->getEmail()) ||
            empty($model->getPassword())
        ) {
            throw new Exception("All fields must be filled in");
        }

        if (!filter_var($model->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Incorrect e-mail");
        }

        if ($this->dao->getUserByEmail($model->getEmail())) {
            throw new Exception("Email already registered");
        }

        if (empty($this->dao->getUserByEmail($model->getEmail()))) {
            throw new Exception("Error registering user in the database");
        }

        $model = $this->dao->save($model);

        if (empty($model)) {
            throw new Exception("Error registering user in the database");
        }

        return $model;
    }

    public function login(User $model): User
    {
        if (empty($model->getEmail()) || empty($model->getPassword())) {
            throw new Exception("All fields must be filled in");
        }

        if (!filter_var($model->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Incorrect e-mail");
        }

        $userExist = $this->dao->getUserByEmail($model->getEmail());

        if (!$userExist) {
            throw new Exception("E-mail or Password incorrect");
        }

        return password_verify($model->getPassword(), $userExist->getPassword()) ?
            $userExist : throw new Exception("E-mail or Password incorrect");
    }
}
