<?php

declare(strict_types=1);

namespace Entity;

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
}
