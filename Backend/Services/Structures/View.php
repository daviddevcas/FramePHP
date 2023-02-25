<?php

namespace Backend\Services\Structures;

use Backend\Services\Structures\Override\ViewContent;
use Backend\Services\Throwable\ViewException;
use Backend\Services\Server\Session;
use Models\User;
use Exception;

class View
{
    protected static $session;

    public function __construct()
    {
        View::$session = new Session();

        if (!View::$session->isSessionActive()) {
            View::$session->init();
        }
    }

    public function render(String $view, array $params = []): void
    {
        try {
            foreach ($params as $key => $value) {
                $$key = $value;
            }
        } catch (Exception $e) {
            error_log($e);
            throw new ViewException('Vars not defined.', 0);
        }

        $file = 'Views/' . $view . '.php';

        if (file_exists($file)) {
            try {
                require($file);
            } catch (Exception $e) {
                error_log($e);
            }
        } else {
            throw new ViewException('File not exist.', 1);
        }
    }

    public function getViewContent(String $view, array $params = []): ViewContent
    {
        return new ViewContent($view, $params);
    }

    public static function getSession(): Session
    {
        return View::$session;
    }

    public static function getUser(): User|null
    {
        return Session::getAuthUser();
    }

    public static function setUser(String $user): void
    {
        View::$session->setCurrentUser($user);
    }

    public function thereCurrentUser(): bool
    {
        return View::$session->getCurrentUser() != null && View::$session->getCurrentUser() != '';
    }

}
