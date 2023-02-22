<?php

namespace Backend\Services\Structures;

use Backend\Services\Server\DataBase;
use PDOStatement;

abstract class Model extends DataBase
{
    protected static function query(String $query): PDOStatement
    {
        return DataBase::$pdo->query($query);
    }

    protected static function prepare(String $query, array $array): PDOStatement
    {
        $sql =  DataBase::$pdo->prepare($query);
        $sql->execute($array);

        return $sql;
    }

    abstract function save();
    abstract function destroy();
    abstract static function first();
    abstract static function last();
    abstract static function create(array $values);
    abstract static function read(String $byColumn = null, $value = null, array $arg = null);
    abstract static function update(int $id, array $values);
    abstract static function delete(int $id);
}
