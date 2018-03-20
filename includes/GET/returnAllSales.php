<?php
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