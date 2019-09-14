<?php
/**
 * Created by PhpStorm.
 * User: HOkwuenu
 * Date: 9/14/2019
 * Time: 11:41 AM
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/customers.php';


// instantiate database and customer object
$database = new Database();
$db = $database->getConnection();

// initialize object
$customers = new Customers($db);

// query customers
$cust = $customers->read();
$num = $cust->rowCount();

// check if more than 0 record found
if($num>0){

    // products array
    $customers_arr=array();
    $customers_arr["records"]=array();

    // retrieve our table contents // fetch() is faster than fetchAll()
    while ($row = $cust->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $customers_item=array(
            "id" => $customer_id,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
            "gender" => $gender,
            "ip_address" => $ip_address
        );

        array_push($customers_arr["records"], $customers_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($customers_arr);

} else {

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user there were no customers found
    echo json_encode(
        array("message" => "No customers found.")
    );
}
