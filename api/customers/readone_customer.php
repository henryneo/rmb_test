<?php
/**
 * Created by PhpStorm.
 * User: HOkwuenu
 * Date: 9/14/2019
 * Time: 1:12 PM
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');


// include database and object files
include_once '../config/database.php';
include_once '../objects/customers.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare customer object
$customer = new Customers($db);

// set ID property of record to read
$customer->customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : die();

// read the details of customer to be viewed or edited
$customer->readOne();

if($customer->first_name != null){
    // create array
    $customer_arr = array(
        "customer_id" =>  $customer->customer_id,
        "first_name" => $customer->first_name,
        "last_name" => $customer->last_name,
        "email" => $customer->email,
        "gender" => $customer->gender,
        "ip_address" => $customer->ip_address
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($customer_arr);

} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user customer does not exist
    echo json_encode(array("message" => "Customer does not exist."));
}
?>