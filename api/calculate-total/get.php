<?php
header("Content-Type: application/json; charset=UTF-8");

include_once 'shared/calculatePrices.php';
include_once 'shared/utilities.php';

$winesParam = isset($_GET['wines']) ? $_GET['wines'] : null;
$distanceParam = isset($_GET['distance']) ? $_GET['distance'] : null;

if (empty($winesParam) || !strpos($winesParam, ":") || !isset($distanceParam)) {
    http_response_code(400);
    die(json_encode(array(
        "message" => "Não foi possível calcular os preços, dados estão incorretos.\nInformar: wines=key:value,key:value...&distance:kilometros"
    )));
}

$distance = (float) $distanceParam;

$winesQuantity = stringToArrayWithKeys($winesParam);

echo json_encode(calculate($winesQuantity, $distance));