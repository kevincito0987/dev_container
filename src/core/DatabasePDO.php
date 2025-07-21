<?php

namespace App\core;

use PDO;
use PDOException;

class DatabasePDO
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            require_once "src/config.php";
            try {
                self::$connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die(json_encode(["error" => $e->getMessage(),  'code' => 500, 'errorUrl' => 'https://http.cat/500']));
            }
        }
        return self::$connection;
    }
}
