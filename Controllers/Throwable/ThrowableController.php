<?php

namespace Controllers\Throwable;

use Backend\Services\Structures\Override\Controller;

class ThrowableController extends Controller
{
    private String $message;
    private String $typeError;
    private array $messageError = ['404' => 'Ésta página no existe.', '500' => 'Ocurrió un error en el servidor.'];

    function __construct(String $typeError, String $message = '')
    {
        $this->typeError = $typeError;
        $this->message = $message;
        parent::__construct();
    }

    public function render(): void
    {
        $vars['message'] = $this->message;
        $vars['typeError'] = $this->typeError;
        $vars['messageError'] = $this->messageError[$this->typeError];
        $this->getView()->render('Throwable/throwable_page', $vars);
    }
}
