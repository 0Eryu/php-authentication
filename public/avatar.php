<?php
declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\UserAvatar;

try {
    if (!isset($_GET['userId'])){
        throw new EntityNotFoundException();
    }
    $userId = $_GET['userId'];
    $avatar = UserAvatar::findById((int) $userId);
    var_dump($avatar);
    //header('Content-Type: image/png');
    echo $avatar->getPng();
} catch(EntityNotFoundException $e) {
    $test = file_get_contents('img/default_avatar.png');
    header('Content-Type: image/png');
    echo $test;
}