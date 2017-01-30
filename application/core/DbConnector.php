<?php
namespace Application\Core;

class DbConnector {

    private static $dbInst = null;

    private static $dbh = null;

    protected function __construct()
    {
        $dbConfig = require_once(__DIR__ . '/../config/dbConfig.php');
        self::$dbh = new \PDO('mysql:host=' . $dbConfig["host"] . ';dbname=' . $dbConfig["database"], $dbConfig["user"], $dbConfig["pswd"]);
    }

    protected function __clone()
    {

    }

    protected function __wakeup()
    {

    }

    public static function get_instance()
    {
        if ( ! self::$dbInst)
        {
            self::$dbInst = new self();
            return self::$dbInst;
        }
        else
        {
            return self::$dbInst;
        }
    }

    public function handler()
    {
        return (self::$dbInst) ? self::$dbh : null;
    }
}
