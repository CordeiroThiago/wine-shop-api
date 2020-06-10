<?php
header("Content-Type: application/json; charset=UTF-8");

include_once 'models/WineType.php';

$database = new Database();
$db = $database->getConnection();

$wineType = new WineType($db);

$data = json_decode(file_get_contents("php://input"));

if (empty($data->type)) {
    http_response_code(400);
    die (json_encode(array(
        "message" => "Não foi possível cadastrar o tipo de vinho, dados estão faltando."
    )));
}

$wineType->type = $data->type;

if ($wineType->insert()) {
    http_response_code(201);
    echo json_encode(array("message" => "Tipo de vinho cadastrado."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Não foi possível cadastrar o tipo do vinho."));
}