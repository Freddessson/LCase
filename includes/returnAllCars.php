<?php
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