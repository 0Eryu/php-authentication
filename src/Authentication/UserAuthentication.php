<?php

declare(strict_types=1);

namespace Authentication;

use Authentication\Exception\NotLoggedInException;
use Entity\Exception\EntityNotFoundException;
use Entity\User;
use Html\StringEscaper;
use Authentication\Exception\AuthenticationException;
use Service\Exception\SessionException;
use Service\Session;

class UserAuthentication
{
    use StringEscaper;

    private const LOGIN_INPUT_NAME = 'login';
    private const PASSWORD_INPUT_NAME = 'password';
    private const SESSION_KEY = '__UserAuthentication__';
    private const SESSION_USER_KEY = 'user';
    private const LOGOUT_INPUT_NAME = 'logout';

    /**
     * @var User|null Utilisateur null par défaut.
     */
    private ?User $user = null;

    /**
     * @throws SessionException
     */
    public function __construct()
    {
        try {
            $user = $this->getUserFromSession();
            $this->setUser($user);
        } catch (NotLoggedInException $e) {
        }
    }

    /**
     * @return User
     * @throws NotLoggedInException
     */
    public function getUser(): User
    {
        if (!isset($this->user)) {
            throw new NotLoggedInException('L\'utilisateur que vous essayez de récupérer n\'est pas défini.');
        }

        return $this->user;
    }

    /**
     * @param string $action
     * @param string $submitText
     * @return string Formulaire de connexion.
     */
    public function loginForm(string $action, string $submitText = 'OK'): string
    {
        $login = self::LOGIN_INPUT_NAME;
        $password = self::PASSWORD_INPUT_NAME;

        return <<<HTML
            <form action={$action} method="POST">
                <input type="text" name={$login} id={$login} placeholder={$login}>
                <input type="password" name={$password} id={$password} placeholder={$password}>
                <input type="submit" value={$submitText}>
            </form>
        HTML;
    }

    /**
     * @return User
     * @throws SessionException
     * @throws AuthenticationException
     * @throws EntityNotFoundException
     */
    public function getUserFromAuth(): User
    {
        if (!isset($_POST[self::LOGIN_INPUT_NAME])
            || !isset($_POST[self::PASSWORD_INPUT_NAME])) {
            throw new AuthenticationException('Couple identifiant/mot de passe sont invalides');
        }
        try {
            $user = User::findByCredentials($_POST[self::LOGIN_INPUT_NAME], $_POST[self::PASSWORD_INPUT_NAME]);
            $this->setUser($user);
        } catch (EntityNotFoundException $e) {
            throw new AuthenticationException('Aucun utilisateur trouvé avec le couple identifiant/mot de passe fourni.');
        }

        return $user;
    }

    /**
     * @param User $user Utilisateur.
     * @return void
     * @throws SessionException
     */
    protected function setUser(?User $user): void
    {
        Session::start();
        $_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY] = $user;
        $this->user = $user;
    }

    /**
     * @return bool
     * @throws SessionException
     */
    public function isUserConnected(): bool
    {
        Session::start();
        return isset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY])
            && $_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY] instanceof User;
    }

    /**
     * @param string $action
     * @param string $text
     * @return string
     */
    public function logoutForm(string $action, string $text): string
    {
        $logout = self::LOGOUT_INPUT_NAME;

        return <<<HTML
            <form action={$action} method="POST">
                <label>{$text}</label>
                <input type="submit" value={$logout} name={$logout} id={$logout}>
            </form>
        HTML;
    }

    /**
     * @return void
     * @throws SessionException
     */
    public function logoutIsRequested(): void
    {
        if (isset($_POST[self::LOGOUT_INPUT_NAME])) {
            if (isset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY])) {
                unset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY]);
                $this->setUser(null);
            }
        }
    }

    /**
     * @return User
     * @throws NotLoggedInException
     * @throws SessionException
     */
    public function getUserFromSession(): User
    {
        if ($this->isUserConnected()) {
            $user = $_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY];
        } else {
            throw new NotLoggedInException('L\'utilisateur n\'est pas connecté.');
        }
        return $user;
    }
}
