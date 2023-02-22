<?php

namespace Backend\Services\Structures;

use Exception;

class Collection
{
    private $items = array();

    public function addItem($obj, String $key = null): void
    {
        if ($key == null) {
            $this->items[] = $obj;
        } else {
            if (isset($this->items[$key])) {
                throw new Exception("Key {$key} already in use.");
            } else {
                $this->items[$key] = $obj;
            }
        }
    }

    public function deleteItemByKey($key): void
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        } else {
            throw new Exception("Invalid key {$key}.");
        }
    }

    public function deleteItemByValue($value): void
    {
        $products = array();

        foreach ($this->items as $key => $item) {
            if ($value != $item) {
                $products[$key] = $item;
            }
        }

        $this->items = $products;
    }

    public function getItem($key): mixed
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        } else {
            throw new Exception("Invalid key {$key}.");
        }
    }

    public function setItem($obj, String $key): void
    {
        if (isset($this->items[$key])) {
            $this->items[$key] = $obj;
        } else {
            throw new Exception("Invalid key {$key}.");
        }
    }

    public function keys(): array
    {
        return array_keys($this->items);
    }

    public function length(): int
    {
        return count($this->items);
    }

    public function keyExists(String $key): bool
    {
        return isset($this->items[$key]);
    }

    public function itemExist($item): bool
    {
        foreach ($this->items as $value) {
            if ($item == $value) {
                return true;
            }
        }

        return false;
    }

    public function count(): bool
    {
        return count($this->items) > 0;
    }

    public function clean(): void
    {
        $this->items = array();
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
