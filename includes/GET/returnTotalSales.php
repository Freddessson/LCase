<?php
function returnTotalSales($sales, $employees, $cars)
{
    $data = array();
    //Length of each incoming array
    $lengthOfSales = sizeof($sales);
    $lengthOfEmployees = sizeof($employees);
    $lengthOfCars = sizeof($cars);
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