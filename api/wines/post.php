<?php
header("Content-Type: application/json; charset=UTF-8");

include_once 'models/Wine.php';

$database = new Database();
$db = $database->getConnection();

$wine = new Wine($db);

$data = json_decode(file_get_contents("php://input"));

if (empty($data->name) || empty($data->wine_type_id) || empty($data->weight) || empty($data->price)) {
    http_response_code(400);
    die(json_encode(array(
        "message" => "Não foi possível cadastrar o vinho, dados estão faltando."
    )));
}

$wine->name = $data->name;
$wine->wine_type_id = $data->wine_type_id;
$wine->weight = $data->weight;
$wine->price = $data->price;

if ($wine->insert()) {
    http_response_code(201);
    echo json_encode(array("message" => "Vinho cadastrado."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Não foi possível cadastrar o vinho."));
}