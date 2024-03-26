<?php

class Book extends AbstractEntity
{
    private string $pseudo = "";
    private string $userImage = "";
    private string $title = "";
    private string $author = "";
    private string $description;
    private bool $available;
    private string $image;


    /**
     * Getter pour le titre du livre.
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Setter pour le titre du livre.
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Setter pour le pseudo du vendeur.
     * @param string $pseudo
     */
    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getimage(): string
    {
        return $this->image;
    }

    public function setimage(string $image): void
    {
        $this->image = $image;
    }

    
    public function getuserImage(): string
    {
        return $this->userImage;
    }

    public function setuserImage(string $userImage): void
    {
        $this->userImage = $userImage;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getAvailable(): string
    {
        return $this->available;
    }

    public function setAvailable(bool $available): void
    {
        $this->available = $available;
    }
}