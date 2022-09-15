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



}