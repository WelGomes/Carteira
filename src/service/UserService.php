<?php

namespace Welbert\Carteira\service;

use Exception;
use Welbert\Carteira\dao\UserDAO;
use Welbert\Carteira\exception\UserException;
use Welbert\Carteira\model\User;

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
            throw new UserException("All fields must be filled in");
        }

        if (!filter_var($model->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new UserException("Incorrect e-mail");
        }

        if ($this->dao->getUserByEmail($model->getEmail())) {
            throw new UserException("Email already registered");
        }

        $model = $this->dao->save($model);

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

        $userExist = $this->dao->getUserByEmail($model->getEmail());

        if (!$userExist) {
            throw new UserException("E-mail or Password incorrect");
        }

        return password_verify($model->getPassword(), $userExist->getPassword()) ?
            $userExist : throw new UserException("E-mail or Password incorrect");
    }
}
