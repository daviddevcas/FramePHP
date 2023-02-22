<?php

namespace Backend;

use Backend\Services\Throwable\RouterException;
use Backend\Services\Structures\Collection;

class Router
{
    private static $routes = array();

    public static function add(String $route,String $controller, String $method, bool $session = false): void
    {
        $request = self::getParamsFromUrl($route);

        self::$routes[$request[0]] = ['controller' => $controller, 'method' => $method, 'params' => $request[1], 'session' => $session];
    }

    public static function getAction($route): array
    {
        $url = rtrim($route, '/');
        $url = explode('/', $url);
        $part = '';
        $keyUrl = '';

        for ($i = 0; $i < sizeof($url); $i++) {
            $part .= $i != 0 ? "/{$url[$i]}" : $url[$i];

            if (sizeof($url) - ($i + 1) > 0) {
                $keyUrl = "{$part}/" . (sizeof($url) - ($i + 1));
            } else {
                $keyUrl = $part;
            }

            foreach (self::$routes as $key => $value) {
                if ($key == $keyUrl) {
                    $k = $i + 1;
                    $j = 0;
                    for ($k; $k < sizeof($url); $k++) {
                        if ($j < $value['params']->length()) {
                            $value['params']->setItem($url[$k], $j);
                            $j++;
                        }
                    }

                    return $value;
                }
            }
        }

        throw new RouterException("The route {$route} was not found", 0);
    }

    private static function getParamsFromUrl(String $route): array
    {
        $url = rtrim($route, '/');
        $url = explode('/', $url);
        $i = 0;
        $key = '';
        $params = new Collection();

        for ($i; $i < sizeof($url); $i++) {
            if ($url[$i][0] != '{') {
                $key .= "{$url[$i]}/";
            } else {
                break;
            }
        }

        for ($i; $i < sizeof($url); $i++) {
            $url[$i] =   substr($url[$i], 1);
            $url[$i] =   substr($url[$i], 0, -1);
            $params->addItem($url[$i]);
        }

        if ($params->length() > 0) {
            $key .= $params->length();
        } else {
            $key = substr($key, 0, -1);
        }

        $request[0] = $key;
        $request[1] = $params;

        return $request;
    }
}
