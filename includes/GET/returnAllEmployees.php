<?php
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