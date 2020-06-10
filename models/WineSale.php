<?php
class WineSale{
    private $conn;
    private $table_name = "wine_sales";
    
    // Properties
    public int $sales_id;
    public int $wine_id;
    public int $quantity;
    
    public function __construct($db){
        $this->conn = $db;
    }

    public function insert() : bool {
        $query = '
INSERT INTO '.$this->table_name.' (sales_id, wine_id, quantity)
            VALUES (:sales_id, :wine_id, :quantity)
        ';

        $stmt = $this->conn->prepare($query);

        $this->sales_id = htmlspecialchars(strip_tags($this->sales_id));
        $this->wine_id = htmlspecialchars(strip_tags($this->wine_id));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));

        $stmt->bindParam(':sales_id', $this->sales_id);
        $stmt->bindParam(':wine_id', $this->wine_id);
        $stmt->bindParam(':quantity', $this->quantity);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
}