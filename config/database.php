<?php 
class Database {
    private $conn;
    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname;

     public function __construct($dbname) {
        $this->dbname = $dbname;
    }

     public function connect() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->servername};dbname={$this->dbname}", 
                $this->username, 
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected succesfully";
            return $this->conn;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }

     public function getConnection() {
        return $this->conn;
    }
}


?>