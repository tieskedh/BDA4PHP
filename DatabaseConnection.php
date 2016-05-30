<?php

/**
 * Created by PhpStorm.
 * User: thijs
 * Date: 29-5-2016
 * Time: 19:02
 */
class DatabaseConnection
{
    private static $instance;
    private $_PDO;

    private function __construct() {
        $this->_PDO = new PDO('mysql:host=localhost;dbname=week4;charset=utf8mb4', 'root');
    }

    public static function getConnection() :PDO {
        if (self::$instance==null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance->getRealConnection();
    }
    
    private function getRealConnection() : PDO {
        return $this->_PDO;
    }

    public function __clone()
    {
        return false;
    }
    public function __wakeup()
    {
        return false;
    }
}