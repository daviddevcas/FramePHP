<?php

namespace Backend\Services\Structures;

use Backend\Services\Throwable\ServerException;
use Backend\Services\Validator;

class Manager extends Validator
{
    protected Collection $errorBag;
    protected array $errors;
    protected array $messages;

    public function __construct()
    {
        $this->errorBag = new Collection();
        $this->errors = [
            'integer_error' => ':var must be int.', ':var string_error' => ':var must be string.', 'decimal_error' => ':var must be decimal.',
            'decimal_error_format' => ':var must be decimal format.', 'max_error' => ':var length exceeded the maximum.', 'min_error' => ':var length exceeded the minimum.',
            'regex_error' => ':var does not match with regex.'
        ];
    }

    protected function toRoute(String $route): void
    {
        header('Location:' . constant('URL') . "{$route}");
    }

    protected function addError(String $error): void
    {
        $this->errorBag->addItem($error);
    }

    protected function freeErrorBag(): void
    {
        $this->errorBag->clean();
    }

    protected function getErrorBagToString(): String
    {
        $string = '';

        for ($i = 0; $i < $this->errorBag->length(); $i++) {
            $string .= "{$this->errorBag->getItem($i)}\n";
        }

        return $string;
    }

    protected function countError(): bool
    {
        return $this->errorBag->count();
    }

    protected function validateKeys(array $validates): void
    {
        foreach ($validates as $key => $validate) {
            foreach ($validate as $validations => $value) {
                $errors = $this->validate($validations, $value);

                foreach ($errors->toArray() as $error) {
                    $this->errorBag->addItem(str_replace(':var', $key, $this->errors[$error]));
                }
            }
        }
    }

    protected function valuesPostDefinedState(array $names)
    {
        foreach ($names as $name) {
            if (!isset($_POST[$name])) {
                throw new ServerException("Value post {$name} is not defined.");
            }
        }
    }

    protected function valuesFilesDefinedState(array $names)
    {
        foreach ($names as $name) {
            if (!isset($_FILES[$name])) {
                throw new ServerException("Value file {$name} is not defined.");
            }
        }
    }

    protected function getErrorMessagesToString(): String
    {
        $message = '';

        foreach ($this->errorBag->toArray() as $error) {
            if (!is_null($this->messages[$error])) {
                $message .= "{$this->messages[$error]}\n";
            } else {
                $message .= "{$error}\n";
            }
        }

        return $message;
    }
}
