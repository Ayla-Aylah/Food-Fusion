<?php

namespace Model;
use PDO;
use db\Database;

class Recipe extends Database
{
    public function getFeaturedRecipes()
    {
        $stmt = $this->connect()->prepare("SELECT * FROM recipes WHERE is_featured = 1 ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}

?>