<?php
class Database {
    private $host = "localhost";
    private $db_name = "adega";
    private $username;
    private $password;
    public $conn;

    public function __construct(){
        $this->username = "root";
        $this->password = "";
    }

    public function getConnection() : PDO {
        $this->conn = null;
        $connectionString = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
        
        try{
            $this->conn = new PDO($connectionString, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}