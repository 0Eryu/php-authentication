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

}