<?php
/**
 * Created by PhpStorm.
 * User: niketpathak
 * Date: 31/07/16
 * Time: 23:04
 */

//decode json encoded post data
$params = json_decode(file_get_contents('php://input'),true);
//print_r($params);
$output = array("res"=>0, "msg"=>"Missing Input");     //output array

//check for empty post paramters
if(empty($params["name"]) || empty($params["email"]) || empty($params["booking_date"]) || empty($params["partysize"]) || empty($params["booking_time"])) {
    exit(json_encode($output));
}

//data-type validation
$params["partysize"] = (int) $params["partysize"];
$bookdate = date('Y-m-d', strtotime($params["booking_date"]));  //returns 1970-01-01 if input is invalid
$valid_bookingtimes = array("12", "12:30", "13:00", "13:30", "14:00", "14:30",
    "19:00","19:30","20:00","20:30","21:00","21:30","22:00","22:30","23:00","23:30");
if (!filter_var($params["email"], FILTER_VALIDATE_EMAIL) || empty($params["partysize"]) || $bookdate=="1970-01-01" || !in_array($params["booking_time"], $valid_bookingtimes) ) {
    $output["msg"] = "Invalid Input";
    exit(json_encode($output));
}

//get config
require_once('wp-config.php');
try {
    //open DB connection
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //insert
    $stmt = $db->prepare("INSERT INTO wp_reservations(name,email,date,time,party_size) VALUES(:field1,:field2,:field3,:field4,:field5)");
    $stmt->execute(array(':field1' => $params["name"], ':field2' => $params["email"], ':field3' => $params["booking_date"], ':field4' => $params["booking_time"], ':field5' => $params["partysize"]));
    $affected_rows = $stmt->rowCount();

} catch (PDOException $e) {
    echo "ERROR: ".$e->getMessage();
}

if($affected_rows == 1){
    $output["res"] = "1";
    $output["msg"] = "Reservation Successful. Thank you";
}
exit(json_encode($output));


