<?php

declare(strict_types=1);

namespace Html;

class UserProfileWithAvatar extends UserProfile
{
    public const AVATAR_INPUT_NAME = 'avatar';
    /**
     * @var string
     */
    private string $formAction;

    public function toHtml(): string
    {
        $toHtml = parent::toHtml();
        $toHtml .=
            <<<HTML
                <img src="/avatar?userId={$this->user->getId()}" alt="Avatar de l'utilisateur"/>
            HTML
        ;

        return $toHtml;
    }
}
