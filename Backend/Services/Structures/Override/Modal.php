<?php

namespace Backend\Services\Structures\Override;

use Backend\Services\Throwable\ControllerException;
use Backend\Services\Server\Session;
use Backend\Services\Structures\Json;
use Backend\Services\Structures\Manager;

abstract class Modal extends Manager
{
    protected static Session $session;

    public function __construct()
    {
        Modal::$session = new Session();

        parent::__construct();

        if (!Modal::$session->isSessionActive()) {
            Modal::$session->init();
        }
    }

    protected function thereCurrentUser(bool $case = true): void
    {
        if ($case) {
            if (!Modal::$session->getCurrentUser() != null && Modal::$session->getCurrentUser() != '') {
                throw new ControllerException('Session is not already exist.');
            }
        } else {
            if (Modal::$session->getCurrentUser() != null && Modal::$session->getCurrentUser() != '') {
                throw new ControllerException('Session already exist.');
            }
        }
    }

    abstract public function save(): ViewContent;
    abstract public function edit(int $id): ViewContent;
    abstract public function destroy(int $id): ViewContent;

    abstract public function create(): Json;
    abstract public function update(): Json;
    abstract public function delete(): Json;
}
