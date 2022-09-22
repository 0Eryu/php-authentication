<?php

declare(strict_types=1);

use Authentication\Exception\NotLoggedInException;
use Authentication\UserAuthentication;
use Html\UserProfileWithAvatar;
use Html\WebPage;

$authentication = new UserAuthentication();

$p = new WebPage('Authentification');

try {
    // Tentative de connexion
    $user = $authentication->getUserFromSession();
    //$userProfile = new UserProfile($user);
    $userProfile = new UserProfileWithAvatar($user, $_SERVER['PHP_SELF']);
    $userProfile->updateAvatar();
    $p->appendContent(
        <<<HTML
            <div>Bonjour {$user->getFirstName()}</div>
            {$userProfile->toHtml()}
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
