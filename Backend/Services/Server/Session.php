<?php

namespace Backend\Services\Server;

use Backend\Services\Cache;
use Models\User;

class Session
{
    public function init(): void
    {
        session_set_cookie_params(60*60*24);
        session_start();
        if (!isset($_SESSION['fodap']['user'])) {
            $_SESSION['fodap']['user'] = '';
        }
    }

    public function setCurrentUser(String $user): void
    {
        $_SESSION['fodap']['user'] = $user;
    }

    public function getCurrentUser(): String
    {
        return $_SESSION['fodap']['user'];
    }

    public function closeSession(): void
    {
        session_unset();
        session_destroy();
        Cache::clear();
    }

    public static function getAuthUser(): User| null
    {
        if (Session::isSessionActive()) {
            if ($_SESSION['fodap']['user'] != '') {
                return User::read('email', $_SESSION['fodap']['user']);
            }
        }

        return null;
    }

    public static function isSessionActive(): bool
    {
        return session_status() == PHP_SESSION_ACTIVE;
    }
}
