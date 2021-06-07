<?php


namespace App\Model;

use JMS\Serializer\Annotation as Serializer;

class UserDto
{
    /**
     * @Serializer\Type("string")
     */
    private $email;

    /**
     * @Serializer\Type("string")
     */
    private $username;

    /**
     * @Serializer\Type("string")
     */
    private $password;

    /**
     * @Serializer\Type("array")
     */
    private $roles;

    /**
     * @Serializer\Type("string")
     */
    private $surname;

    /**
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @Serializer\Type("string")
     */
    private $patronymic;

    /**
     * @Serializer\Type("string")
     */
    private $token;

    /**
     * @Serializer\Type("string")
     */
    private $refreshToken;

    /**
     * @Serializer\Type("string")
     */
    private $nameCompany;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
        $this->email= $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(?array $roles): void
    {
        $this->roles = $roles;
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

    public function getNameCompany()
    {
        return $this->nameCompany;
    }

    public function setNameCompany(?string $nameCompany): void
    {
        $this->nameCompany = $nameCompany;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getPatronymic()
    {
        return $this->patronymic;
    }

    public function setPatronymic(?string $patronymic): void
    {
        $this->patronymic = $patronymic;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}
