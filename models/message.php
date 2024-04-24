<?php

class Message extends AbstractEntity
{
    public int $id;
    private string $message = "";
    private string $date;
    private int $id_sender;
    private int $id_receiver;


    /**
     * Getter pour l'id du message
     * @return string
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Setter pour l'id du message
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Setter pour le message
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
    /**
     * Getter pour la date du message
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * Setter pour la date du message
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * Getter pour l'ID de l'expéditeur du message
     * @return int
     */
    public function getIdSender(): int
    {
        return $this->id_sender;
    }

    /**
     * Setter pour l'ID de l'expéditeur du message
     * @param int $id_sender
     */
    public function setIdSender(int $id_sender): void
    {
        $this->id_sender = $id_sender;
    }

    /**
     * Getter pour l'ID du destinataire du message
     * @return int
     */
    public function getIdReceiver(): int
    {
        return $this->id_receiver;
    }

    /**
     * Setter pour l'ID du destinataire du message
     * @param int $id_receiver
     */
    public function setIdReceiver(int $id_receiver): void
    {
        $this->id_receiver = $id_receiver;
    }
}
