<?php

namespace Backend\Services\Structures\Override;

use Backend\Services\Throwable\ViewException;
use Exception;

class ViewContent
{
    public function __construct(String $view, $params = [])
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
}
