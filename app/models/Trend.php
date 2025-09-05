<?php

namespace Model;
use PDO;
use db\Database;

class Trend extends Database
{
 public function getAll() {
        $stmt = $this->connect()->query("SELECT * FROM culinary_trends");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>