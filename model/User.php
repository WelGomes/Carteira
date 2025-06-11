<?php

namespace projeto\model;

use projeto\dao\UserDAO;

final class User
{

    private int $id;
    private string $name;
    private string $lastName;
    private string $email;
    private string $password;

    public function __construct(
        string $name, 
        string $lastName, 
        string $email, 
        string $password
    ){
        $this->name = $name;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }

    public function setId(int $id): void 
    {   
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function getPassword(): string
    {
        return $this->password;
    }

    public function save(): bool
    {
        return new UserDAO()->register($this);
    }

}
