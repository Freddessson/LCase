<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Credentials: true");
header("Content-type: application/json; charset=utf-8");

include 'includes/POST/carmodelsIdCheck.php';
include 'includes/POST/createCarInputCheck.php';
include 'includes/POST/createNewCarmodel.php';
include 'includes/GET/returnAllCars.php';
include 'includes/GET/returnAllEmployees.php';
include 'includes/GET/returnAllSales.php';
include 'includes/GET/returnTotalSales.php';

$jsonData = file_get_contents("data.json");
$jsonData = json_decode($jsonData, true);

//Listening for GET requests
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ($_GET['url'] == "employees") {
        $data = returnAllEmployees($jsonData, $_GET['url']);
        response_delivery(200, "ok", $data);
    } else if ($_GET['url'] == "carmodels") {
        $data = returnAllCars($jsonData, $_GET['url']);
        response_delivery(200, "ok", $data);
    } else if ($_GET['url'] == "total_sales") {
        $sales = returnAllSales($jsonData, "sales");
        $employees = returnAllEmployees($jsonData, "employees");
        $cars = returnAllCars($jsonData, "carmodels");
        $data = returnTotalSales($sales, $employees, $cars);
        response_delivery(200, "ok", $data);
    }
    else{
        response_delivery(400, "Invalid Request", null);
    }
    //Listening for POST requests
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_GET['url'] == "carmodels") {
        $body = file_get_contents("php://input");
        $body = json_decode($body, true);

        $inputCheck = createCarInputCheck($body);
        $carmodelList = returnAllCars($jsonData, "carmodels");
        $idCheck = carmodelsIdCheck($body, $carmodelList);
        if($inputCheck == false){
            response_delivery(400, "Input not valid", $body);
        }
        else if($idCheck == false){
            response_delivery(400, "Id alredy exists", $body);
        }
        else{
            $body = createNewCarmodel($body);
            response_delivery(200, "ok", $body);

        }
    }
}

//Response
function response_delivery($status, $status_message, $data)
{
    header("HTTP/1.1 $status $status_message");
    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;

    $json_response = json_encode($response);
    echo $json_response;
}
