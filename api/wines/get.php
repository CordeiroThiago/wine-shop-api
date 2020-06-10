<?php
header("Content-Type: application/json; charset=UTF-8");

include_once 'models/Wine.php';

$database = new Database();
$db = $database->getConnection();

$wine = new Wine($db);

$result = $wine->read( isset($_GET['id']) ? $_GET['id'] : null );
$qtd = $result->rowCount();

if ($qtd > 0) {
    $wines = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $wineItem = array(
            'wine_id' => (int) $wine_id,
            'name' => $name,
            'wine_type_id' => (int) $wine_type_id,
            'type' => $type,
            'weight' => (float) $weight,
            'price' => (float) $price
        );

        array_push($wines, $wineItem);
    }

    echo json_encode($wines);
} else {
    echo json_encode(
        array('message' => 'Nenhum vinho encontrado.')
    );
}