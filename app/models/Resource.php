<?php

namespace Model;

use PDO;
use db\Database;

class Resource extends Database
{
    // Fetch all recipe cards
    public function getRecipeCards()
    {
        $sql = "SELECT * FROM culinary_resources_recipe_cards ORDER BY created_at DESC";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all tutorial videos
    public function getTutorialVideos()
    {
        $sql = "SELECT * FROM culinary_resources_tutorials ORDER BY created_at DESC";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all kitchen hacks
    public function getKitchenHacks()
    {
        $sql = "SELECT * FROM culinary_resources_hacks ORDER BY created_at DESC";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
public function getDownloads()
{
    $sql = "SELECT * FROM educational_resources WHERE type = 'download' ORDER BY created_at DESC";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getInfographics()
{
    $sql = "SELECT * FROM educational_resources WHERE type = 'infographic' ORDER BY created_at DESC";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getculInfographics()
{
    $sql = "SELECT * FROM culinary_resources_infographics ORDER BY created_at DESC";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getVideos()
{
    $sql = "SELECT * FROM educational_resources WHERE type = 'video' ORDER BY created_at DESC";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}






}
?>