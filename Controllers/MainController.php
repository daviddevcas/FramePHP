<?php

namespace Controllers;

use Backend\Services\Structures\Override\Controller;
use Backend\Services\Throwable\ControllerException;
use Backend\Services\Structures\Json;
use Backend\Public\Tools;
use Models\User;
use Exception;

class MainController extends Controller
{
    private array $codes = [
        'a26bf5c5' => 'Ha creado su cuenta con éxito. Espere a que se valide su cuenta para poder iniciar sesión.',
        'f0cea769' => 'Ha cambiado la contraseña de su cuenta con éxito.'
    ];

    private User $user;

    function __construct()
    {
        parent::__construct();
        if (!is_null($this->getView()->getUser())) {
            $this->user = $this->getView()->getUser();
        }
    }

    public function render(): void
    {
        if ($this->getView()->thereCurrentUser()) {
            if ($this->user->hasPermission('admin.home')) {
                $this->toRoute('Admin');
            } else if ($this->user->hasPermission('sales.home')) {
                $this->getView()->render('Sales/sales');
            } else {
                $this->getView()->render('Main/main');
            }
        } else {
            $this->getView()->render('Main/main');
        }
    }

    public function caducable(): void
    {
        $this->getView()->render('Main/caducable');
    }

    public function log(): void
    {
        if (!$this->getView()->thereCurrentUser()) {
            $this->getView()->render('Main/log');
        } else {
            $this->render();
        }
    }

    public function renderConfirmPage(String $code): void
    {
        $this->getView()->render('Main/confirm', ['msj' => $this->codes[$code]]);
    }

    public function recoverAccount(): void
    {
        if (!$this->getView()->thereCurrentUser()) {
            $this->getView()->render('Main/recover');
        } else {
            $this->toRoute('Main');
        }
    }

    public function login(): Json
    {
        $json = ['message' => ''];

        try {
            $this->thereCurrentUser(false);
            $this->valuesPostDefinedState(['nickname', 'password']);

            $user = User::read('nickname', $_POST['nickname']);
            if (is_null($user)) {
                throw new ControllerException('Nickname incorrect.');
            }
            if (password_verify($_POST['password'], $user->password)) {
                $this->getView()->getSession()->setCurrentUser($user->nickname);
                $this->getView()->setUser($user->nickname);
                $json = ['message' => 'Session is init.'];
            } else {
                throw new ControllerException('Password incorrect.');
            }
        } catch (Exception $e) {
            if (!($e instanceof ControllerException)) {
                error_log($e);
            }

            $json = ['message' => $e->getMessage()];
        } finally {
            return new Json($json);
        }
    }

    public function createAccount(): Json
    {
        $json = ['message' => ''];

        try {
            $this->thereCurrentUser(false);
            $this->valuesPostDefinedState(['name', 'lastname', 'password', 'nickname', 'password-confirm']);

            if ($_POST['password'] == $_POST['password-confirm']) {
                if (!is_null(User::read('nickname', $_POST['nickname']))) {
                    throw new ControllerException('Account already exist.');
                }
                $_POST['password'] = Tools::passwordCrypt($_POST['password']);
                User::create($_POST);

                $json = ['message' => 'Account was created.'];
            } else {
                throw new ControllerException('Passwords not equals.');
            }
        } catch (Exception $e) {
            if (!($e instanceof ControllerException)) {
                error_log($e);
            }
            $json = ['message' => $e->getMessage()];
        } finally {
            return new Json($json);
        }
    }

    public function rewriteHash(): Json
    {
        try {
            $this->thereCurrentUser(false);
            $this->valuesPostDefinedState(['nickname']);

            $user = User::read('nickname', $_POST['nickname']);

            if (is_null($user)) {
                throw new ControllerException('Nickname incorrect.');
            }
            $user->rewriteHash();
            $user->save();
            $json = ['message' => 'Hash has been successfully rewritten.'];
        } catch (Exception $e) {
            if (!($e instanceof ControllerException)) {
                error_log($e);
            }
            $json = ['message' => $e->getMessage()];
        } finally {
            return new Json($json);
        }
    }

    function verifyHashOnNickname(): Json
    {
        try {
            $this->thereCurrentUser(false);
            $this->valuesPostDefinedState(['nickname', 'hash']);

            $user = User::read('nickname', $_POST['nickname']);

            if (is_null($user)) {
                throw new ControllerException('Nickname or hash incorrect.');
            }

            if ($user->hash != strval($_POST['hash'])) {
                throw new ControllerException('Nickname or hash incorrect.');
            }

            $json = ['message' => 'User verified.'];
        } catch (Exception $e) {
            if (!($e instanceof ControllerException)) {
                error_log($e);
            }
            $json = ['message' => $e->getMessage()];
        } finally {
            return new Json($json);
        }
    }

    function updateAccount(): Json
    {
        try {
            $this->thereCurrentUser(false);
            $this->valuesPostDefinedState(['nickname', 'password', 'password-confirm']);

            if ($_POST['password'] != $_POST['password-confirm']) {
                throw new ControllerException('Passwords not equals.');
            }
            $user = User::read('nickname', $_POST['nickname']);

            if (is_null($user)) {
                throw new ControllerException('Nickname not exist.');
            }

            if (!password_verify($_POST['password'], $user->password)) {
                $user->password = Tools::passwordCrypt($_POST['password']);
                $user->save();
                $json = ['message' => 'User updated.'];
            } else {
                throw new ControllerException('Password repeat.');
            }
        } catch (Exception $e) {
            if (!($e instanceof ControllerException)) {
                error_log($e);
            }
            $json = ['message' => $e->getMessage()];
        } finally {
            return new Json($json);
        }
    }
}
