<?php

declare(strict_types=1);

namespace Html;

use Entity\User;

class UserProfileWithAvatar extends UserProfile
{

    public const AVATAR_INPUT_NAME = 'avatar';
    /**
     * @var string
     */
    private string $formAction;

    /**
     * @param string $formAction
     */
    public function __construct(string $formAction)
    {
        $this->formAction = $formAction;
    }

    public function toHtml(): string
    {
        $avatarInputName = self::AVATAR_INPUT_NAME;
        $toHtml = parent::toHtml();
        $toHtml .=
            <<<HTML
                <form action={$this->formAction} method="POST">
                    <input type="file" name="{$avatarInputName}" id="{$avatarInputName}">
                    <input type="submit" value="Mettre à jour">
                </form>
                <img src="/avatar?userId={$this->user->getId()}" alt="Avatar de l'utilisateur"/>
            HTML
        ;

        return $toHtml;
    }
}
