<?php
include_once 'models/Wine.php';
include_once 'models/Prices.php';

function calculate(array $winesQuantity, float $distance) : Prices {
    $database = new Database();
    $db = $database->getConnection();
    $wine = new Wine($db);

    $wines = array_keys($winesQuantity);

    $result = $wine->read( implode(",", $wines) );
    $qtd = $result->rowCount();

    if ($qtd > 0) {
        $wines = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $wine_item = array(
                'wine_id' => (int) $wine_id,
                'weight' => (float) $weight,
                'price' => (float) $price,
                'quantity' => (int) $winesQuantity[(int) $wine_id]
            );

            array_push($wines, $wine_item);
        }

        return new Prices($wines, $distance);
    } else {
        return new Prices(array(), 1);
    }
}