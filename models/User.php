<?php
class User extends AbstractEntity
{
    public int $id;
    public string $pseudo;
    public string $email;
    public string $password;
    public string $register_date;
    public string|null $image;


    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }
    public function getPseudo(): string
    {
        return $this->pseudo;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
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
    public function setRegisterDate(string $register_date): void
    {
        $this->register_date = $register_date;
    }
    public function getRegisterDate(): string
    {
        return $this->register_date;
    }
    public function setimage(string|null $image): void
    {
        $this->image = $image;
    }
    public function getimage(): string
    {
        return $this->image;
    }
}