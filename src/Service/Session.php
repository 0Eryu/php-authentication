<?php

declare(strict_types=1);

namespace Service;

use Service\Exception\SessionException;

class Session
{
    /**
     * @return void
     * @throws SessionException
     */
    public static function start(): void
    {
        $sessionStatus = session_status();

        if ($sessionStatus === PHP_SESSION_DISABLED) {
            throw new SessionException('Le module de session n\'est pas activé sur le serveur.');
        } elseif ($sessionStatus === PHP_SESSION_NONE) {
            if (!headers_sent()) {
                session_start();
            } else {
                throw new SessionException('Une session est déjà lancée sur le serveur.');
            }
        }
    }
}
