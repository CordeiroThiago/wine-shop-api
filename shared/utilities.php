<?php
/**
 * Recusa requests com metodos que não estejam de acordo
 * com o valor informado no parametro `$allowedMethod`
*/
function stringToArrayWithKeys(string $str) : array {
    $arr = array();
    foreach (explode(",", $str) as $strInfo) {
        $strInfo = explode(":", $strInfo);
        $arr[(int) $strInfo[0]] = (int) $strInfo[1];
    }
    return $arr;
}

function objectToArrayWithKeys(array $array) : array {
    $arr = array();
    foreach ($array as $info) {
        foreach ($info as $key => $value)
            $arr[$key] = (int) $value;
    }
    return $arr;
}