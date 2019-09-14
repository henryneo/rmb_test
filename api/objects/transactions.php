<?php
/**
 * Created by PhpStorm.
 * User: HOkwuenu
 * Date: 9/14/2019
 * Time: 11:37 AM
 */

class Transactions{

    // database connection and table name
    private $conn;
    private $table_name = "transactions";
    private $customers_table = "customers";


    // object properties
    public $transaction_id;
    public $customer_id;
    public $trans_description;
    public $trans_value;
    public $trans_date;
    public $country;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read customers from the db
    function read(){

        // select all query
        $query = "SELECT transaction_id, customer_id, trans_description, trans_value, trans_date, country FROM ".$this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function getCustomerName($customer_id){


        $query = "SELECT first_name, last_name FROM ".$this->customers_table." WHERE customer_id = $customer_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['first_name'].' '.$row['last_name'];
    }
}