<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class UserAvatar
{
    /**
     * @var int Identifiant de l'avatar.
     */
    private int $id;
    /**
     * @var ?string Avatar au format PNG pouvant être null.
     */
    private ?string $avatar;

    protected function __construct()
    {
    }


    /**
     * @return int Récupération de l'identifiant de l'avatar.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null Récupération de la chaine de caractère
     * représentant l'avatar au format PNG, pouvant être null.
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param int $userId Identifiant de l'utilisateur dans la base de donnée.
     * @return $this Chaine de caractère correspondant à un avatar au format PNG.
     * @throws EntityNotFoundException Utilisateur non trouvé avec l'identifiant placé en paramètre.
     */
    public static function findById(int $userId): self
    {
        $query = MyPdo::getInstance()->prepare(
            <<<SQL
                SELECT id, avatar
                FROM user
                WHERE id = :userId
            SQL
        );

        $query->execute([':userId' => $userId]);
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, UserAvatar::class);
        $userAvatar = $query->fetch();

        if ($userAvatar === false) {
            throw new EntityNotFoundException('Aucun utilisateur correspondant à cet identifiant et à ce mot de passe a été trouvé dans la base de donnée');
        }

        return $userAvatar;
    }

    /**
     * @param string|null $avatar
     */
    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return $this
     * @throws EntityNotFoundException
     */
    public function save(): UserAvatar
    {
        $insert = MyPdo::getInstance()->prepare(
            <<<SQL
                UPDATE user 
                SET avatar = :avatar
                WHERE id = :id
            SQL
        );
        $insert->execute([':avatar' => $this->getAvatar(), ':id' => $this->getId()]);

        return $this;
    }

    /**
     * @return int
     */
    public function maxFileSize(): int
    {
        return 65535;
    }
}
