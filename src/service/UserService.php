<?php

namespace src\service;

use src\dao\UserDAO;
use src\exception\UserException;
use src\model\User;

final class UserService
{
    private UserDAO $UserDAO;

    public function __construct()
    {
        $this->UserDAO = new UserDAO();
    }

    public function register(User $model): User
    {
        if (
            empty($model->getName()) ||
            empty($model->getLastName()) ||
            empty($model->getEmail()) ||
            empty($model->getPassword())
        ) {
            throw new UserException("All fields must be filled in");
        }

        if (!filter_var($model->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new UserException("Incorrect e-mail");
        }

        if ($this->UserDAO->getUserByEmail($model->getEmail())) {
            throw new UserException("Email already registered");
        }

        $model = $this->UserDAO->save($model);

        if (empty($model)) {
            throw new UserException("Error registering user in the database");
        }

        return $model;
    }

    public function login(User $model): User
    {
        if (empty($model->getEmail()) || empty($model->getPassword())) {
            throw new UserException("All fields must be filled in");
        }

        if (!filter_var($model->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new UserException("Incorrect e-mail");
        }

        $userExist = $this->UserDAO->getUserByEmail($model->getEmail());

        if (!$userExist) {
            throw new UserException("E-mail or Password incorrect");
        }

        return password_verify($model->getPassword(), $userExist->getPassword()) ?
            $userExist : throw new UserException("E-mail or Password incorrect");
    }
}
