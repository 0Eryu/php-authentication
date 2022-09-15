<?php

declare(strict_types=1);

namespace Authentication;

use Entity\User;
use Html\StringEscaper;
use Authentication\Exception\AuthenticationException;
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

    public function getUserFromAuth(): User
    {
        $user = User::findByCredentials($_POST[self::LOGIN_INPUT_NAME], $_POST[self::PASSWORD_INPUT_NAME]);

        if ($user === false) {
            throw new AuthenticationException('Le couple login-mot de passe est incorrect.');
        }

        $this->setUser($user);

        return $user;
    }

    /**
     * @param User $user Utilisateur.
     * @return void
     * @throws \Service\Exception\SessionException
     */
    protected function setUser(User $user): void
    {
        Session::start();
        $_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY] = $user;
        $this->user = $user;
    }

    /**
     * @return bool
     * @throws \Service\Exception\SessionException
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
    public function logoutForm(string $action, string $text) : string
    {
        $logout = self::LOGOUT_INPUT_NAME;
        return <<<HTML
            <form action={$action} method="POST">
                <p>{$text}</p>
                <input type="submit" value={$logout}>
            </form>
        HTML;

    }

    /**
     * @return void
     */
    public function logoutIsRequested() : void
    {
        if ($_POST[self::LOGOUT_INPUT_NAME]){
            if (isset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY])) {
                unset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY]);
            }
        }

    }
}
