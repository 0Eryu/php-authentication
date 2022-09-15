<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

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

    /**
     * Recherche dans la base de donnée l'utilisateur correspondant au login et au mot de passe passés
     * en paramètres.
     *
     * @param string $login Identifiant de l'utilisateur.
     * @param string $password Mot de passe de l'utilisateur.
     * @return User Utilisateur correspondant à l'identifiant et au mot de passe mis en paramètres.
     */
    public static function findByCredentials(string $login, string $password) : User
    {
        $query = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id, lastName, firstName, login, phone
            FROM user
            WHERE login = :login AND sha512pass = SHA2(:password, 512)
            SQL
        );

        $query->execute([':login' => $login, ':password' => $password]);
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, User::class);
        $user = $query->fetch();

        if ($user === false) {
            throw new EntityNotFoundException('Aucun utilisateur correspondant à cet identifiant et à ce mot de passe a été trouvé dans la base de donnée');
        }

        return $user;
    }

}