<?php

declare(strict_types=1);

use Authentication\UserAuthentication;
use Html\WebPage;

$authentication = new UserAuthentication();

// Un utilisateur est-il connecte ?
if (!$authentication->isUserConnected()) {
    // Rediriger vers le formulaire de connexion
    die(); // Fin du programme
}

$title = 'Zone membre';
$p = new WebPage($title);

$p->appendContent(
    <<<HTML
        <h1>Zone membre connecté</h1>
        <h2>Page 1</h2>
HTML
);

echo $p->toHTML();
