<?php

namespace Backend\Services\Structures\Override;

use Backend\Services\Structures\Manager;
use Backend\Services\Structures\View;
use Backend\Services\Throwable\ControllerException;

abstract class Controller extends Manager
{

    private View $view;

    public function __construct()
    {
        parent::__construct();
        $this->view = new View();
    }
    
    protected function getView(): View
    {
        return $this->view;
    }

    protected function thereCurrentUser(bool $case = true): void
    {
        if ($case) {
            if (!$this->view->thereCurrentUser()) {
                throw new ControllerException('Session is not already exist.');
            }
        } else {
            if ($this->view->thereCurrentUser()) {
                throw new ControllerException('Session already exist.');
            }
        }
    }

    abstract function render();
}
