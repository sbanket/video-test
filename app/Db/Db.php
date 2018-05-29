<?php

namespace App\Db;

use PDO;
use PDOException;

/**
 * Class Db
 *
 * @package App\Db
 */
class Db
{
    private static $_instance = null;
    private $connection;

    /**
     * @return Db|null
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    protected function __clone()
    {
    }

    /**
     * Mysql constructor
     */
    private function __construct()
    {
        try {
            $dsn = sprintf('mysql:host=%s;dbname=%s', getenv('DB_HOST'), getenv('DB_DATABASE'));

            $this->connection = new PDO($dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        } catch (PDOException $e) {
            die("Failed to connect to DB: " . $e->getMessage());
        }
    }
}