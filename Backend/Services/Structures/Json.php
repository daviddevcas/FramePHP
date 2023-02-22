<?php

namespace Backend\Services\Structures;

class Json
{
    private array $jsonForm = array();

    public function __construct(array $jsonForm)
    {
        $this->jsonForm = $jsonForm;

        echo $this->toJson();
    }

    public function toJson(): string|false
    {
        return json_encode($this->jsonForm);
    }

    public static function fromJson(String $json): Json
    {
        return new Json(json_decode($json));
    }
}
