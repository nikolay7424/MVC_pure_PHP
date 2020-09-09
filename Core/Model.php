<?php


namespace Core;

use PDO;
use PDOException;

abstract class Model
{
    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            $host = 'localhost';
            $dbname = 'MVC_pure_PHP';
            $username = 'root';
            $password = '';

            try {
                $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
                    $username, $password);

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        return $db;
    }
}