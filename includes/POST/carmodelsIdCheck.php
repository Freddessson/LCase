<?php
function carmodelsIdCheck($body, $carmodelList)
{
    $bool = true;
    $idToCompare = $body['id'];
    $length = sizeof($carmodelList);
    for ($i = 0; $i < $length; $i++) {
        $id = $carmodelList[$i]['id'];
        if($id == $idToCompare){
            $bool = false;
        }
    }
    return $bool;
}