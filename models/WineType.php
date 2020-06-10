<?php
class WineType{
    private $conn;
    private $table_name = "wine_types";
    
    // Properties
    public int $wine_type_id;
    public string $type;
    
    public function __construct($db){
        $this->conn = $db;
    }

    public function read(string $idList = null) : PDOStatement {
        $query = '
SELECT wine_type_id, type
  FROM '.$this->table_name.'
 WHERE 1=1
        ';

        if (!empty($idList)) {
            $query .= ' AND wine_type_id IN ('.$idList.') ';
        }

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function insert() : bool {
        $query = '
INSERT INTO '.$this->table_name.' (type)
            VALUES (:type)
        ';

        $stmt = $this->conn->prepare($query);

        $this->type = htmlspecialchars(strip_tags($this->type));

        $stmt->bindParam(':type', $this->type);

        if($stmt->execute()){
            return true;
        }
        
        return false;
    }
}