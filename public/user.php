<?php

declare(strict_types=1);

use Authentication\Exception\NotLoggedInException;
use Authentication\UserAuthentication;
use Authentication\Exception\AuthenticationException;
use Html\WebPage;

$authentication = new UserAuthentication();

$p = new WebPage('Authentification');

try {
    // Tentative de connexion
    $user = $authentication->getUserFromSession();
    $p->appendContent(
        <<<HTML
            <div>Bonjour {$user->getFirstName()}</div>
        HTML
    );
} catch (NotLoggedInException $e) {
    header('Location: /form.php');
    exit();
} catch (Exception $e) {
    $p->appendContent("Un problème est survenu&nbsp;: {$e->getMessage()}");
}

// Envoi du code HTML au navigateur du client
echo $p->toHTML();
