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
     * @var string Avatar au format PNG.
     */
    private string $png;
}