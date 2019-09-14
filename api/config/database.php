<?php
/**
 * Created by PhpStorm.
 * User: HOkwuenu
 * Date: 9/14/2019
 * Time: 11:30 AM
 */

class Database{

    // specify database credentials
    private $host = "localhost";
    private $db_name = "rmbx";
    private $username = "root";
    private $password = "";
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>