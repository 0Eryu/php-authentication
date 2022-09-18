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
    $userTest = $authentication->getUserFromSession();
    $authentication->logoutIsRequested();
    $form = $authentication->logoutForm('form.php', 'Se déconnecter');
    $user = $authentication->getUser();
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
} catch (SessionException $e) {
    $p->appendContent("Échec : {$e->getMessage()}");
} catch (NotLoggedInException $e) {
    // Production du formulaire de connexion
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
} catch (AuthenticationException $e) {
    $p->appendContent("Échec d'authentification&nbsp;: {$e->getMessage()}");
} catch (Exception $e) {
    $p->appendContent("Un problème est survenu&nbsp;: {$e->getMessage()}");
}


echo $p->toHTML();
