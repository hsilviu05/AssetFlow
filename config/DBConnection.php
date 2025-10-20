<?php
    class DBConnection 
    {
        private static $instance = null;
        private $connection;

        private function __construct() 
        {
            $dbFile = __DIR__ . '/database.sqlite';
            $this->connection = new PDO('sqlite:' . $dbFile);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->exec("PRAGMA foreign_keys = ON;");
        }

        public static function getInstance() 
        {
            if (self::$instance === null) 
            {
                self::$instance = new DBConnection();
            }
            return self::$instance;
        }

        public function getConnection() 
        {
            return $this->connection;
        }
    }
?>