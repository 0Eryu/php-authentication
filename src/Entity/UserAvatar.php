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
    private ?string $png;

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
    public function getPng(): ?string
    {
        return $this->png;
    }

    /**
     * @param int $userId Identifiant de l'utilisateur dans la base de donnée.
     * @return $this Chaine de caractère correspondant à un avatar au format PNG.
     * @throws EntityNotFoundException Utilisateur non trouvé avec l'identifiant placé en paramètre.
     */
    public function findById(int $userId): self
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
        $user = $query->fetch();

        if ($user === false) {
            throw new EntityNotFoundException('Aucun utilisateur correspondant à cet identifiant et à ce mot de passe a été trouvé dans la base de donnée');
        }

        return $user;
    }
}
