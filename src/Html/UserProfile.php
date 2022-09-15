<?php

declare(strict_types=1);

namespace Html;

use Entity\User;

class UserProfile
{
    use StringEscaper;

    /**
     * @var User Utilisateur.
     */
    private User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function toHtml(): string
    {
        return <<<HTML
            <dl>
                <dt>Nom</dt>
                <dd>{$this->escapeString($this->user->getLastname())}</dd>
            
                <dt>Prénom</dt>
                <dd>{$this->escapeString($this->user->getFirstname())}</dd>
            
                <dt>Login</dt>
                <dd>{$this->escapeString($this->user->getLogin())} [{$this->user->getId()}]</dd>
            
                <dt>Téléphone</dt>
                <dd>{$this->escapeString($this->user->getPhone())}</dd>
            </dl>
        HTML;
    }
}
