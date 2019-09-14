<?php
/**
 * Created by PhpStorm.
 * User: HOkwuenu
 * Date: 9/14/2019
 * Time: 11:33 AM
 */

class Customers{

    // database connection and table name
    private $conn;
    private $table_name = "customers";


    // object properties
    public $customer_id;
    public $first_name;
    public $last_name;
    public $email;
    public $gender;
    public $ip_address;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read customers from the db
    function read(){

        // select all query
        $query = "SELECT customer_id, first_name, last_name, email, gender, ip_address FROM ".$this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }


    // used when reading and also updating a single customer
    function readOne(){

        // query to read single record
        $query = "SELECT customer_id, first_name, last_name, email, gender, ip_address FROM ".$this->table_name." WHERE customer_id = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of customer to be viewed/updated
        $stmt->bindParam(1, $this->customer_id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->first_name = $row['first_name'];
        $this->last_name = $row['last_name'];
        $this->email = $row['email'];
        $this->gender = $row['gender'];
        $this->ip_address = $row['ip_address'];
    }
}