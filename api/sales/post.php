<?php
header("Content-Type: application/json; charset=UTF-8");

include_once 'shared/calculatePrices.php';
include_once 'shared/utilities.php';
include_once 'models/Sale.php';
include_once 'models/WineSale.php';

$data = json_decode(file_get_contents("php://input"));

$winesParam = isset($data->wines) ? $data->wines : null;
$distanceParam = isset($data->distance) ? $data->distance : null;

if (empty($winesParam) || !isset($distanceParam)) {
    http_response_code(400);
    die(json_encode(array(
        "message" => "Não foi possível registrar a venda, dados estão incorretos."
    )));
}

$distance = (float) $distanceParam;

$winesQuantity = objectToArrayWithKeys($winesParam);
$wines = array_keys($winesQuantity);

$prices = calculate($winesQuantity, $distance);

$database = new Database();
$db = $database->getConnection();
$db->beginTransaction();

$sale = new Sale($db);

$sale->distance = $distance;
$sale->total_price = $prices->total;

$saleId = $sale->insert();
if ($saleId) {
    foreach ($wines as $wine) {
        $wineSale = new WineSale($db);

        $wineSale->sales_id = $saleId;
        $wineSale->wine_id = $wine;
        $wineSale->quantity = $winesQuantity[(int) $wine];

        if (!$wineSale->insert()) {
            http_response_code(503);
            echo json_encode(array("message" => "Não foi possível vincular a venda aos vinhos."));
        }
    }

    $db->commit();

    http_response_code(201);
    echo json_encode(array(
        "message" => "Venda registrada.",
        "final_price" => $prices->total
    ));

    exit;
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Não foi possível registrar a venda."));
}

$db->rollBack();