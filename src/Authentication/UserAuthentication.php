<?php

declare(strict_types=1);

namespace Authentication;

use Entity\User;
use Html\StringEscaper;

class UserAuthentication
{
    use StringEscaper;

    private const LOGIN_INPUT_NAME = 'login';
    private const PASSWORD_INPUT_NAME = 'password';

    private const SESSION_KEY = '__UserAuthentication__';
    private const SESSION_USER_KEY = 'user';

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

        return $user;
    }
}
