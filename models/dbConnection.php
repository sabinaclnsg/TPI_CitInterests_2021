<?php

namespace CitInterests\models;

require_once 'inc.php';

if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = "";
}


class DBConnection
{
    static $conn = null;
    // connect to the database
    const NOM_BASE = DB_NAME;
    const HOST = DB_HOST;
    const USER = DB_USER;
    const PWD = DB_PWD;

    // returns a PDO connection object
    private static function doConnection()
    {
        try {
            self::$conn = new \PDO(
                "mysql:host=" . self::HOST .
                    ";dbname=" . self::NOM_BASE,
                self::USER,
                self::PWD,
                array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    \PDO::ATTR_PERSISTENT => false
                )
            );
            self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            echo '<pre>Erreur : ' . $e->getMessage() . '</pre>';
            die('Could not connect to MySQL');
        }
        return self::$conn;
    }

    public static function getConnection()
    {
        if (self::$conn == null) {
            self::doConnection();
        }
        return self::$conn;
    }
}
