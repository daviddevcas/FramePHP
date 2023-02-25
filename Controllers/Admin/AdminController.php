<?php

namespace Controllers\Admin;

use Backend\Services\Structures\Override\Controller;
use Models\User;

class AdminController extends Controller
{
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
            $this->getView()->render('Admin/home');
        } else {
            $this->toRoute('Main');
        }
    }
}
