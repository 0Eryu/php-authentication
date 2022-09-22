<?php

declare(strict_types=1);

use Authentication\Exception\AuthenticationException;
use Authentication\Exception\NotLoggedInException;
use Authentication\UserAuthentication;
use Html\UserProfile;
use Html\WebPage;
use Service\Exception\SessionException;

// Création de l'authentification
$authentication = new UserAuthentication();

$p = new WebPage('Authentification');

try {
    $user = $authentication->getUser();
    $authentication->logoutIfRequested();
    $form = $authentication->logoutForm('form.php', 'Se déconnecter');
    $userProfile = new UserProfile($user);
    $p->appendContent(
        <<<HTML
                <div>Bonjour {$user->getFirstName()}</div>
                <div>{$userProfile->toHtml()}</div>
            HTML
    );
    $p->appendContent(
        <<<HTML
                {$form}
            HTML
    );
} catch (NotLoggedInException $e) {
    $p->appendCSS(
        <<<CSS
                form input {
                    width : 4em ;
                }
            CSS
    );
    $form = $authentication->loginForm('auth.php');
    $p->appendContent(
        <<<HTML
                {$form}
                <p>Pour faire un test : essai/toto
            HTML
    );
} catch (Exception $e) {
    $p->appendContent("Un problème est survenu&nbsp;: {$e->getMessage()}");
}


echo $p->toHTML();
