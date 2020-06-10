<?php
header("Content-Type: application/json; charset=UTF-8");

include_once 'models/WineType.php';

$database = new Database();
$db = $database->getConnection();

$wineType = new WineType($db);

$result = $wineType->read( isset($_GET['id']) ? $_GET['id'] : null );
$qtd = $result->rowCount();

if ($qtd > 0) {
    $types = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $wineType = array(
            'wine_type_id' => (int) $wine_type_id,
            'type' => $type,
        );

        array_push($types, $wineType);
    }

    echo json_encode($types);
} else {
    echo json_encode(
        array('message' => 'Nenhum tipo de vinho encontrado. Favor cadastrar')
    );
}