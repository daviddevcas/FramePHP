<?php

namespace Backend\Services\Server;

use PDOException;
use PDO;

class DataBase
{
    private static string $host;
    private static string $db;
    private static string $user;
    private static string $password;
    private static string $charset;
    protected static PDO $pdo;

    public static function init(): void
    {
        DataBase::$host = constant('HOST');
        DataBase::$db = constant('DB');
        DataBase::$password = constant('PASSWORD');
        DataBase::$charset = constant('CHARSET');
        DataBase::$user = constant('USER');
        DataBase::$pdo = DataBase::connect();
    }

    private static function connect(): PDO
    {
        try {
            $connection = 'mysql:host=' . DataBase::$host . ';dbname=' . DataBase::$db . ';charset=' . DataBase::$charset;

            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false];

            return new PDO($connection, DataBase::$user, DataBase::$password, $options);
        } catch (PDOEXception $e) {
            error_log('Error connection: ' . $e->getMessage());
            return null;
        }
    }
}
