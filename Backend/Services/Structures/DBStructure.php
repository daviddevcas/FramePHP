<?php

namespace Backend\Services\Structures;

use Backend\Services\Server\DataBase;
use PDOException;

class DBStructure extends DataBase
{
   public static function begin(): bool
   {
      if (!is_null(DataBase::$pdo)) {
         return   DataBase::$pdo->beginTransaction();
      } else {
         throw new PDOException('Object PDO is not defined.');
      }
   }

   public static function commit(): bool
   {
      if (!is_null(DataBase::$pdo)) {
         return  DataBase::$pdo->commit();
      } else {
         throw new PDOException('Object PDO is not defined.');
      }
   }

   public static function rollback(): bool
   {
      if (!is_null(DataBase::$pdo)) {
         return  DataBase::$pdo->rollBack();
      } else {
         throw new PDOException('Object PDO is not defined.');
      }
   }

   public static function inTransaction(): bool
   {
      if (!is_null(DataBase::$pdo)) {
         return DataBase::$pdo->inTransaction();
      } else {
         throw new PDOException('Object PDO is not defined.');
      }
   }
}
