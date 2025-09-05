<?php

namespace AdminModel;
use PDO;
use db\Database;
use PDOException;
class Recipe extends Database
{
    public function postRecipe($data)
    {
        try {
        $conn = $this->connect(); // ✅ Create connection once
        $sql = "INSERT INTO recipes
        (title, description, recipe_tips, nutrition, cuisine_type, dietary_preference, difficulty, image_path, cooking_time,
        is_featured, created_at, postedby)
        VALUES
        (:recipe_title, :recipe_description, :recipe_tips, :nutrition, :cuisine, :diet, :difficulty, :image_path, :cooking_time,
        0, NOW(), 'admin')";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':recipe_title', $data['recipe_title']);
        $stmt->bindParam(':recipe_description', $data['recipe_description']);
        $stmt->bindParam(':recipe_tips', $data['recipe_tips']);
        $stmt->bindParam(':nutrition', $data['nutrition']);
        $stmt->bindParam(':cuisine', $data['cuisine']);
        $stmt->bindParam(':diet', $data['diet']);
        $stmt->bindParam(':difficulty', $data['difficulty']);
        $stmt->bindParam(':image_path', $data['recipe_photo']);
        $stmt->bindParam(':cooking_time', $data['cooking_time']);

        if ($stmt->execute()) {
            return $conn->lastInsertId();
        }
        return false;
        } 
        catch (PDOException $e) {
            error_log("Insert recipe failed: " . $e->getMessage());
            return false;
        }
    }


    public function uploadRecipePhoto($fileInputName, $subFolder = 'recipes/', $allowedTypes = ['jpg', 'jpeg', 'png'],
    $maxSize = 2 * 1024 * 1024)
    {
        if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'No file uploaded or upload error.'];
        }
            $file = $_FILES[$fileInputName];
            $fileName = basename($file['name']);
            $fileSize = $file['size'];
            $fileTmpPath = $file['tmp_name'];
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        // Validate file type
        if (!in_array($fileType, $allowedTypes)) {
            return ['error' => 'Invalid file type. Allowed types: ' . implode(', ', $allowedTypes)];
        }
        if (!isset($_FILES[$fileInputName]) || empty($_FILES[$fileInputName]['name']) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
            return ['error' => 'No file uploaded or upload error.'];
        }

        // Validate file size
        if ($fileSize > $maxSize) {
            return ['error' => 'File size exceeds the maximum limit of ' . ($maxSize / 1024 / 1024) . ' MB.'];
        }
        // Create subfolder if it doesn't exist
        $uploadDir = __DIR__ . '/../../public/uploads/' . $subFolder;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        // Generate a unique file name to avoid overwriting
        $uniqueFileName = uniqid('', true) . '.' . $fileType;
        $destinationPath = $uploadDir . '/'. $uniqueFileName;

        // Move the uploaded file to the destination path
        if (move_uploaded_file($fileTmpPath, $destinationPath)) {
            return ['path' => '/uploads/' . $subFolder . $uniqueFileName];
        } else {
            return ['error' => 'Failed to move uploaded file.'];
        }
    }

    Public function getAllRecipes()
    {
        $stmt = $this->connect()->prepare("SELECT * FROM recipes ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function deleteRecipe($id)
    {
        $stmt = $this->connect()->prepare("DELETE FROM recipes WHERE id = ?");
        return $stmt->execute([$id]);
    }
  

    public function getRecipeById($id)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM recipes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function toggleFeatured($recipeId, $isFeatured)
    {
        $stmt = $this->connect()->prepare("UPDATE recipes SET is_featured = :is_featured WHERE id = :recipe_id");
        $stmt->bindParam(':is_featured', $isFeatured, PDO::PARAM_BOOL);
        $stmt->bindParam(':recipe_id', $recipeId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function addRecipeIngredient($recipeId, $ingredient, $quantity, $unit)
    {
        $sql = "INSERT INTO recipe_ingredients (recipe_id, ingredient_name, quantity, unit)
        VALUES (:recipe_id, :ingredient_name, :quantity, :unit)";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([
        'recipe_id' => $recipeId,
        'ingredient_name' => $ingredient,
        'quantity' => $quantity,
        'unit' => $unit
        ]);
    }

    public function addRecipeInstruction($recipeId, $stepNumber, $stepText)
    {
        $sql = "INSERT INTO recipe_instructions (recipe_id, step_number, step_text)
        VALUES (:recipe_id, :step_number, :step_text)";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([
        'recipe_id' => $recipeId,
        'step_number' => $stepNumber,
        'step_text' => $stepText
        ]);
    }

    public function updateRecipe($data)
    {
        $sql = "UPDATE recipes SET title = :recipe_title, description = :recipe_description, 
        recipe_tips = :recipe_tips, nutrition = :nutrition, cuisine_type = :cuisine, 
        dietary_preference = :diet, difficulty = :difficulty, image_path = :image_path, 
        cooking_time = :cooking_time WHERE id = :recipe_id";

        $stmt = $this->connect()->prepare($sql);

        return $stmt->execute([
        'recipe_title' => $data['recipe_title'],
        'recipe_description' => $data['recipe_description'],
        'recipe_tips' => $data['recipe_tips'],
        'nutrition' => $data['nutrition'],
        'cuisine' => $data['cuisine'],
        'diet' => $data['diet'],
        'difficulty' => $data['difficulty'],
        'image_path' => $data['recipe_photo'],
        'cooking_time' => $data['cooking_time'],
        'recipe_id' => $data['recipe_id']
        ]);
    }


    public function deleteRecipeIngredients($recipeId)
    {
        $sql = "DELETE FROM recipe_ingredients WHERE recipe_id = :recipe_id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute(['recipe_id' => $recipeId]);
    }


    public function deleteRecipeInstructions($recipeId)
    {
        $sql = "DELETE FROM recipe_instructions WHERE recipe_id = :recipe_id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute(['recipe_id' => $recipeId]);
    }
    
    public function getRecipeIngredients($recipeId)
    {
        $sql = "SELECT * FROM recipe_ingredients WHERE recipe_id = :recipe_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['recipe_id' => $recipeId]); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecipeInstructions($recipeId)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM recipe_instructions WHERE recipe_id = ? ORDER BY step_number");
        $stmt->execute([$recipeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getIngredientsByRecipeId($id)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM recipe_ingredients WHERE recipe_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getInstructionsByRecipeId($id)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM recipe_instructions WHERE recipe_id = ? ORDER BY step_number");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function hasLiked($userId, $recipeId) {
        $stmt = $this->connect()->prepare("SELECT id FROM recipe_likes WHERE user_id = ? AND recipe_id = ?");
        $stmt->execute([$userId, $recipeId]);
        return $stmt->fetch() !== false;
    }

    public function hasFav($userId, $recipeId) {
        $stmt = $this->connect()->prepare("SELECT id FROM favorites WHERE user_id = ? AND recipe_id = ?");
        $stmt->execute([$userId, $recipeId]);
        return $stmt->fetch() !== false;
    }

    public function addLike($userId, $recipeId) {
        $stmt = $this->connect()->prepare("INSERT IGNORE INTO recipe_likes (user_id, recipe_id) VALUES (?, ?)");
        $stmt->execute([$userId, $recipeId]);
    }

    public function addFav($userId, $recipeId) {
        $stmt = $this->connect()->prepare("INSERT IGNORE INTO favorites (user_id, recipe_id) VALUES (?, ?)");
        $stmt->execute([$userId, $recipeId]);
    }

    public function getCommentsByRecipeId($recipeId)
    {
        $stmt = $this->connect()->prepare("
            SELECT rc.comment, rc.created_at, u.username,  u.profile_image
            FROM recipe_comments rc
            JOIN users u ON rc.user_id = u.id
            WHERE rc.recipe_id = ?
            ORDER BY rc.created_at DESC
        ");
        $stmt->execute([$recipeId]);
        return $stmt->fetchAll();
    }

    
    public function addComment($recipeId, $userId, $comment)
    {
        $stmt = $this->connect()->prepare("INSERT INTO recipe_comments (recipe_id, user_id, comment) VALUES (?, ?, ?)");
        return $stmt->execute([$recipeId, $userId, $comment]);
    }

    public function removeLike($userId, $recipeId) {
        $stmt = $this->connect()->prepare("DELETE FROM recipe_likes WHERE user_id = ? AND recipe_id = ?");
        $stmt->execute([$userId, $recipeId]);
    }

    public function removeFav($userId, $recipeId) {
        $stmt = $this->connect()->prepare("DELETE FROM favorites WHERE user_id = ? AND recipe_id = ?");
        $stmt->execute([$userId, $recipeId]);
    }


    public function countLikes($recipeId) {
        $stmt = $this->connect()->prepare("SELECT COUNT(*) FROM recipe_likes WHERE recipe_id = ?");
        $stmt->execute([$recipeId]);
        return $stmt->fetchColumn();
    }

    
    public function countFav($recipeId) {
        $stmt = $this->connect()->prepare("SELECT COUNT(*) FROM favorites WHERE recipe_id = ?");
        $stmt->execute([$recipeId]);
        return $stmt->fetchColumn();
    }

}
?>