<?php

declare(strict_types=1);

use Authentication\UserAuthentication;
use Authentication\Exception\AuthenticationException;
use Html\WebPage;

$authentication = new UserAuthentication();

$p = new WebPage('Authentification');

try {
    // Tentative de connexion
    $user = $authentication->getUserFromAuth();
    $p->appendContent(
        <<<HTML
<div>Bonjour {$user->getFirstName()}</div>
HTML
    );
} catch (AuthenticationException $e) {
    // Récupération de l'exception si connexion échouée
    $p->appendContent("Échec d'authentification&nbsp;: {$e->getMessage()}");
} catch (Exception $e) {
    $p->appendContent("Un problème est survenu&nbsp;: {$e->getMessage()}");
}

// Envoi du code HTML au navigateur du client
echo $p->toHTML();
