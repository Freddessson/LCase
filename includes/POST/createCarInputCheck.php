<?php
function createCarInputCheck($inputArray){
    $id = $inputArray['id'];
    $brand = $inputArray['brand'];
    $model = $inputArray['model'];
    $price = $inputArray['price'];
    if(is_int($id) && is_int($price) && is_string($brand) && is_string($model)){
        return true;
    }else{
        return false;
    }
}