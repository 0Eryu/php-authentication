<?php
declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\UserAvatar;

try {
    if (!isset($_GET['userId'])){
        throw new EntityNotFoundException('La query string n\'existe pas.');
    }
    $userId = $_GET['userId'];
    $avatar = UserAvatar::findById((int) $userId);
    $userAvatar = $avatar->getAvatar();
    if (is_null($userAvatar)){
        throw new EntityNotFoundException('La query string n\'existe pas.');
    }
} catch(EntityNotFoundException $e) {
    $userAvatar = file_get_contents('img/default_avatar.png');
}
header('Content-Type: image/png');
echo $userAvatar;