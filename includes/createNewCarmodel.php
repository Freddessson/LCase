<?php
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