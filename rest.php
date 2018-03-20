<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Credentials: true");
header("Content-type: application/json; charset=utf-8");


$jsonData = file_get_contents("data.json");
$jsonData = json_decode($jsonData, true);


if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ($_GET['url'] == "employees") {
        $data = returnAllEmployees($jsonData, $_GET['url']);
        response_delivery(200, "ok", $data);
    } else if ($_GET['url'] == "carmodels") {
        $data = returnAllCars($jsonData, $_GET['url']);
        response_delivery(200, "ok", $data);
    } else if ($_GET['url'] == "total_sales") {
        //$data = totalSales($jsonData, "employees", "sales");
        $sales = returnAllSales($jsonData, "sales");
        $employees = returnAllEmployees($jsonData, "employees");
        $cars = returnAllCars($jsonData, "carmodels");
        $data = returnTotalSales($sales, $employees, $cars);
        response_delivery(200, "ok", $data);
    }
    else{
        response_delivery(400, "Invalid Request", null);
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_GET['url'] == "carmodels") {
        $body = file_get_contents("php://input");
        $body = json_decode($body, true);
        $body = createNewCarmodel($body);
        response_delivery(200, "ok", $body);
    }
}

function createNewCarmodel($inputArray)
{
    $data = array();
    $id = $inputArray['id'];
    $brand = $inputArray['brand'];
    $model = $inputArray['model'];
    $price = $inputArray['price'];

    $row = array(
        "id" => $id,
        "brand" => $brand,
        "model" => $model,
        "price" => $price,
    );

    //Open and decode the data.json file
    $jsonData = file_get_contents("data.json");
    $jsonData = json_decode($jsonData, true);

    //Adds the new car to the carmodels
    array_push($jsonData['carshop']['carmodels'], $row);

    //Encodes to json
    $jsonData = json_encode($jsonData);
    file_put_contents('data.json', $jsonData);

    //Encode the new car and return
    array_push($data, $row);
    json_encode($data);
    return $data;
}

function returnTotalSales($sales, $employees, $cars)
{
    $data = array();
    //Length of each incoming array
    $lengthOfSales = sizeof($sales);
    $lengthOfEmployees = sizeof($employees);
    $lengthOfCars = sizeof($cars);
    //$sale = array();
    //Loop all employees
    for ($i = 0; $i < $lengthOfEmployees; $i++) {
        $name = $employees[$i]['name'];
        $id = $employees[$i]['id'];
        $total_sale = 0;
        //Loop through Sales
        for ($j = 0; $j < $lengthOfSales; $j++) {

            $employee_id = $sales[$j]['employee_id'];
            $carmodel_id = $sales[$j]['carmodel_id'];
            //Copmare employee id with "employee_id" in sales to find what each employee sold.
            if ($id == $employee_id) {
                //Find out the price of the car
                for ($k = 0; $k < $lengthOfCars; $k++) {
                    $carId = $cars[$k]['id'];
                    if ($carmodel_id == $carId) {
                        $carPrice = $cars[$k]['price'];
                        //Adds together the price of every car sold by this employee
                        $total_sale += $carPrice;
                    }
                }
            }
        }
        $row = array(
            "name" => $name,
            "id" => $id,
            "total_sale" => $total_sale,
        );
        array_push($data, $row);
    }
    json_encode($data);
    return $data;
}

function returnAllSales($jsonFile, $returnThis)
{
    $data = array();
    $length = sizeof($jsonFile['carshop'][$returnThis]);
    for ($i = 0; $i < $length; $i++) {
        $id = $jsonFile['carshop'][$returnThis][$i]['id'];
        $employee_id = $jsonFile['carshop'][$returnThis][$i]['employee_id'];
        $carmodel_id = $jsonFile['carshop'][$returnThis][$i]['carmodel_id'];
        $row = array(
            "id" => $id,
            "employee_id" => $employee_id,
            "carmodel_id" => $carmodel_id
        );
        array_push($data, $row);
    }
    json_encode($data);
    return $data;

}

function returnAllEmployees($jsonFile, $returnThis)
{
    $data = array();
    $length = sizeof($jsonFile['carshop'][$returnThis]);
    for ($i = 0; $i < $length; $i++) {
        $name = $jsonFile['carshop'][$returnThis][$i]['name'];
        $id = $jsonFile['carshop'][$returnThis][$i]['id'];
        $row = array(
            "id" => $id,
            "name" => $name
        );
        array_push($data, $row);
    }
    json_encode($data);
    return $data;
}

function returnAllCars($jsonFile, $returnThis)
{
    $data = array();
    $length = sizeof($jsonFile['carshop'][$returnThis]);
    for ($i = 0; $i < $length; $i++) {

        $id = $jsonFile['carshop'][$returnThis][$i]['id'];
        $brand = $jsonFile['carshop'][$returnThis][$i]['brand'];
        $model = $jsonFile['carshop'][$returnThis][$i]['model'];
        $price = $jsonFile['carshop'][$returnThis][$i]['price'];
        $row = array(
            "id" => $id,
            "brand" => $brand,
            "model" => $model,
            "price" => $price,
        );
        array_push($data, $row);
    }
    json_encode($data);
    return $data;
}

function response_delivery($status, $status_message, $data)
{
    header("HTTP/1.1 $status $status_message");
    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;

    $json_response = json_encode($response);
    echo $json_response;

}


?>