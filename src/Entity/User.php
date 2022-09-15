<?php
declare(strict_types=1);

namespace Entity;

class User
{
    /**
     * @var int Identifiant de l'utilisateur
     */
    private int $id;
    /**
     * @var string Prénom de l'utilisateur
     */
    private string $firstname;
    /**
     * @var string Nom de famille de l'utilisateur
     */
    private string $lastname;
    /**
     * @var string Mot de passe de l'utilisateur
     */
    private string $login;
    /**
     * @var string Numéro de téléphone de l'utilisateur
     */
    private string $phone;

    /**
     * @return int Identifiant de l'utilisateur
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string Prénom de l'utilisateur
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string Nom de famille de l'utilisateur
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @return string Mot de passe de l'utilisateur
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string Numéro de téléphone de l'utilisateur
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

}