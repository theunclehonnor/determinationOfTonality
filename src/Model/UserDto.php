<?php

namespace App\Model;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    private $username;

    private $email;

    private $password;

    private $roles = [];

    private $surname;

    private $name;

    private $patronymic;

    private $nameCompany;

    /**
     * @Serializer\Type("string")
     */
    private $token;

    /**
     * @Serializer\Type("string")
     */
    private $refreshToken;

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
        $this->email = $username;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname): void
    {
        $this->surname = $surname;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getPatronymic()
    {
        return $this->patronymic;
    }

    public function setPatronymic($patronymic): void
    {
        $this->patronymic = $patronymic;
    }

    public function getNameCompany()
    {
        return $this->nameCompany;
    }

    public function setNameCompany($nameCompany): void
    {
        $this->nameCompany = $nameCompany;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    public function setRefreshToken(?string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }
}
