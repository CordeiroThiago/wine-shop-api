<?php
include_once 'WineSale.php';

class Sale{
    private $conn;
    private $table_name = "sales";
    
    // Properties
    public int $sale_id;
    public float $distance;
    public float $total_price;
    
    public function __construct($db){
        $this->conn = $db;
    }

    public function insert () : int {
        $query = '
INSERT INTO '.$this->table_name.' (distance, total_price)
            VALUES (:distance, :total_price)
        ';

        $stmt = $this->conn->prepare($query);

        $this->distance = htmlspecialchars(strip_tags($this->distance));
        $this->total_price = htmlspecialchars(strip_tags($this->total_price));

        $stmt->bindParam(':distance', $this->distance);
        $stmt->bindParam(':total_price', $this->total_price);

        if($stmt->execute()){
            $query = 'SELECT LAST_INSERT_ID() as id';

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['id'];
        }

        return 0;
    }
}