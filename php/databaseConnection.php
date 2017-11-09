<?php

    class Database{
  
        private $servername = "localhost";
        private $username = "root";
        private $password = "";
        private $dbname = "verde_mar";
        public $conn;

        public function dbConnection() {
            $this->conn = null;    
            try {
                $this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->dbname, $this->username, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
            }
            catch(PDOException $exception) {
                echo "Connection error: " . $exception->getMessage();
            }
         
            return $this->conn;
        }

    }

?>