<?php
class Wine{
    private $conn;
    private $table_name = "wines";
    
    // Properties
    public int $wine_id;
    public string $name;
    public int $wine_type_id;
    public int $type;
    public float $weight;
    public float $price;
    
    public function __construct($db){
        $this->conn = $db;
    }

    public function read(string $idList = null) : PDOStatement {
        $query = '
SELECT w.wine_id, w.name, w.wine_type_id, t.type, w.weight, w.price
  FROM '.$this->table_name.' w LEFT JOIN wine_types t
       ON (w.wine_type_id = t.wine_type_id)
 WHERE 1=1
        ';

        if (isset($idList)) {
            $query .= ' AND w.wine_id IN ('.$idList.') ';
        }

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function insert() : bool {
        $query = '
INSERT INTO '.$this->table_name.' (name, wine_type_id, weight, price)
            VALUES (:name, :wine_type_id, :weight, :price)
        ';

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->wine_type_id = htmlspecialchars(strip_tags($this->wine_type_id));
        $this->weight = htmlspecialchars(strip_tags($this->weight));
        $this->price = htmlspecialchars(strip_tags($this->price));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':wine_type_id', $this->wine_type_id);
        $stmt->bindParam(':weight', $this->weight);
        $stmt->bindParam(':price', $this->price);

        if($stmt->execute()){
            return true;
        }
        
        return false;
    }
}