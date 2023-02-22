<?php

error_reporting(E_ALL);

ini_set('ignore_repeated_errors', true);
ini_set('display_errors', false);
ini_set('log_errors', true);
ini_set('error_log', 'errors_exe');

spl_autoload_register(function ($class_name) {
  include $class_name . '.php';
});

use Backend\Services\Throwable\RouterException;
use Controllers\Throwable\ThrowableController;
use Backend\Services\Throwable\ViewException;
use Backend\App;



try {
  include 'Backend\Config.php';
  include 'Backend\Http\Routes.php';
  new App();
} catch (ViewException $e) {
  switch ($e->getCode()) {
    case 0:
      $controller = new ThrowableController('500', 'Las variables no han sido inicializadas.');
      break;
    case 1:
      $controller = new ThrowableController('404', 'La página no existe.');
      break;
    default:
      $controller = new ThrowableController('500', 'Error inesperado dentro de la vista.');
      error_log($e);
  }
} catch (RouterException $e) {
  switch ($e->getCode()) {
    case 0:
      $controller = new ThrowableController('500', 'La ruta no existe.');
      break;
    default:
      $controller = new ThrowableController('500', 'Error inesperado.');
      error_log($e);
  }
} catch (PDOException $e) {
  $controller = new ThrowableController('500', 'Error inesperado dentro de los modelos.');
  error_log($e);
} catch (Exception $e) {
  $controller = new ThrowableController('500', 'Error inesperado.');
  error_log($e);
} finally {
  if (isset($controller)) {
    $controller->render();
  }
}
