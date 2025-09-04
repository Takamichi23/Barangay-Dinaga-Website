<?php

class Database{
    private $host = "localhost";
    private $dbname = "rjambakery_db";
    private $username = "root";
    private $password = "";
    private $conn;


    public function connect(){
        $this->conn = null;

        try{
            $dsn = 'mysql:host=' .  $this->host . ';dbname=' .  $this->dbname . ';charset=utf8'; 
             //set PDO attributeS
             $this->conn = new PDO($dsn, $this->username, $this->password );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo 'Connection Error: ' . $e->getMessage();
            // echo "There is problem with the system. Please try again later";
        }

        //echo 'Connection successfully';
        return $this->conn;
    }
}

//$db = new Database();
//$db->connect();

//$worker = new Worker($db->connect();)
//$product = new Product($db->connect();)
?>