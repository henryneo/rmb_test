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
include_once '../objects/transactions.php';


// instantiate database and customer object
$database = new Database();
$db = $database->getConnection();

// initialize object
$transactions = new Transactions($db);

// query customers
$trans = $transactions->read();
$num = $trans->rowCount();

// check if more than 0 record found
if($num>0){

    // products array
    $transactions_arr=array();
    $transactions_arr["records"]=array();

    // retrieve our table contents // fetch() is faster than fetchAll()
    while ($row = $trans->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $transaction_items=array(
            "tnx_id" => $transaction_id,
            "customer" => $transactions->getCustomerName($customer_id),
            "tnx_description" => html_entity_decode($trans_description),
            "tnx_value" => $trans_value,
            "tnx_date" => date('Y-m-d', strtotime($trans_date)),
            "country" => $country
        );

        array_push($transactions_arr["records"], $transaction_items);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($transactions_arr);

} else {

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user there were no transactions found
    echo json_encode(
        array("message" => "No transactions found.")
    );
}
