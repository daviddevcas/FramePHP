<?php

use Controllers\MainController;
use Backend\Router;

Router::add('Caducate', MainController::class, 'caducable');

Router::add('Main', MainController::class, 'render');
Router::add('Main/log', MainController::class, 'log');
Router::add('Main/login', MainController::class, 'login');
Router::add('Main/create', MainController::class, 'createAccount');
Router::add('Main/recover', MainController::class, 'recoverAccount');
Router::add('Main/confirm/{code}', MainController::class, 'renderConfirmPage');
Router::add('Main/rewrite', MainController::class, 'rewriteHash');
Router::add('Main/verify/hash', MainController::class, 'verifyHashOnNickname');
Router::add('Main/update', MainController::class, 'updateAccount');

