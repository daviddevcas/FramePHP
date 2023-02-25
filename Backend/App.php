<?php

namespace Backend;

use Backend\Services\Server\DataBase;
use Backend\Services\Server\Session;
use Controllers\MainController;
use Backend\Router;

class App
{
    public function __construct()
    {
        DataBase::init();
        $url = isset($_GET['url']) ? $_GET['url'] : null;

        if (!isset($url)) {
            $controller = new MainController();
            $controller->render();
        } else {
            $action = Router::getAction($url);

            $controller = new $action['controller']();
            $method = $action['method'];


            if (!$action['session']) {
                if ($action['params']->count()) {
                    $params = $action['params']->toArray();
                    $controller->$method(...$params);
                } else {
                    $controller->$method();
                }
            } else {
                if (Session::isSessionActive()) {
                    if ($action['params']->count()) {
                        $params = $action['params']->toArray();
                        $controller->$method(...$params);
                    } else {
                        $controller->$method();
                    }
                } else {
                    $controller = new MainController();
                    $controller->caducable();
                }
            }
        }
    }
}
