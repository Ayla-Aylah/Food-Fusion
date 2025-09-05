<?php

namespace AdminModel;
use PDO;
use db\Database;
use PDOException;
class CookBook extends Database
{
    Public function getAllRecipes()
    {
        $stmt = $this->connect()->prepare("SELECT * FROM user_recipes ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function deleteRecipe($id)
    {
        $stmt = $this->connect()->prepare("DELETE FROM user_recipes WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
  public function deletelikes($recipeId)
    {
        $sql = "DELETE FROM user_recipelikes WHERE recipe_id = :recipe_id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute(['recipe_id' => $recipeId]);
    }

      public function deleteTip($id)
    {
        $stmt = $this->connect()->prepare("DELETE FROM recipe_tips WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
      public function deleteExp($id)
    {
        $stmt = $this->connect()->prepare("DELETE FROM experiences WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getRecipeById($id)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM user_recipes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
       public function getTipByID($id)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM recipe_tips WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
       public function getExpByID($id)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM experiences WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function toggleApproved($recipeId, $isApproved)
    {
        $stmt = $this->connect()->prepare("UPDATE user_recipes SET is_approved = :is_approved WHERE id = :recipe_id");
        $stmt->bindParam(':is_approved', $isApproved, PDO::PARAM_BOOL);
        $stmt->bindParam(':recipe_id', $recipeId, PDO::PARAM_INT);
        return $stmt->execute();
    }
        public function tiptoggleApproved($tipid, $isApproved)
    {
        $stmt = $this->connect()->prepare("UPDATE recipe_tips SET is_approved = :is_approved WHERE id = :tipid");
        $stmt->bindParam(':is_approved', $isApproved, PDO::PARAM_BOOL);
        $stmt->bindParam(':tipid', $tipid, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
        public function exptoggleApproved($id, $isApproved)
    {
        $stmt = $this->connect()->prepare("UPDATE experiences SET is_approved = :is_approved WHERE id = :id");
        $stmt->bindParam(':is_approved', $isApproved, PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function deleteRecipeIngredients($recipeId)
    {
        $sql = "DELETE FROM user_recipeingredients WHERE recipe_id = :recipe_id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute(['recipe_id' => $recipeId]);
    }
    
    public function deleteRecipeInstructions($recipeId)
    {
        $sql = "DELETE FROM user_recipeinstructions WHERE recipe_id = :recipe_id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute(['recipe_id' => $recipeId]);
    }
     
    Public function getAllTips()
    {
        $stmt = $this->connect()->prepare("SELECT rt.*, u.profile_image FROM recipe_tips rt JOIN users u ON rt.user_id = u.id ORDER BY createdat DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    Public function getAllexp()
    {
        $stmt = $this->connect()->prepare("SELECT ex.*, u.profile_image FROM experiences ex JOIN users u ON ex.user_id = u.id ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}