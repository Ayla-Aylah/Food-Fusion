<?php
namespace AdminModel;
use PDO;
use db\Database;

class AdminResource extends Database {

    // Add Recipe Card
    public function addRecipeCard($data) {
        $sql = "INSERT INTO culinary_resources_recipe_cards (title, description, file_path, cover_photo, cuisine, diet, difficulty, cooking_time)
                VALUES (:title, :description, :file_path, :cover_photo, :cuisine, :diet, :difficulty, :cooking_time)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':file_path', $data['file_path']);
        $stmt->bindParam(':cover_photo', $data['cover_photo']);
        $stmt->bindParam(':cuisine', $data['cuisine']);
        $stmt->bindParam(':diet', $data['diet']);
        $stmt->bindParam(':difficulty', $data['difficulty']);
        $stmt->bindParam(':cooking_time', $data['cooking_time']);
        return $stmt->execute();
        $stmt->execute($data);
    }
    public function addHacks($data) {
        $sql = "INSERT INTO culinary_resources_hacks (title, description, video_link)
                VALUES (:title, :description, :video_link)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':video_link', $data['video_file']);
        return $stmt->execute();
        $stmt->execute($data);
    }
    public function addEducationalResource($data) {
    $sql = "INSERT INTO educational_resources (title, description, type, file_path,cover_image, created_at)
            VALUES (:title, :description, :type, :file_path, :cover_image, NOW())";

    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':title', $data['title']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':type', $data['type']);
    $stmt->bindParam(':file_path', $data['file_path']);
    $stmt->bindParam(':cover_image', $data['cover_image']);
    return $stmt->execute();
}

public function uploadHackFile($field)
{
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== 0) {
        return null;
    }

    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/foodfusion/public/uploads/videos/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $extension = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
    $fileName = uniqid('', true) . '.' . $extension;
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES[$field]['tmp_name'], $targetPath)) {
        return "uploads/videos/$fileName";
    }

    return null;
}

public function deleteById($id) {
   
    $sql = "DELETE FROM educational_resources WHERE id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}  
public function deletehackById($id) {
   
    $sql = "DELETE FROM culinary_resources_hacks WHERE id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}  
public function uploadEducationalFile($field, $type) {
    if (empty($_FILES[$field]['tmp_name'])) {
        return null;
    }
    $folder = ($type === 'download') ? 'resources' : 'infographics';
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/foodfusion/public/uploads/$folder/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $extension = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
    $fileName = uniqid('', true) . '.' . $extension;
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES[$field]['tmp_name'], $targetPath)) {
        return "uploads/$folder/$fileName";
    }
    return null;
}



    public function addCookingTutorial($data) {
    $sql = "INSERT INTO culinary_resources_tutorials 
            (title, description, video_link, cuisine, diet, difficulty, cooking_time, created_at)
            VALUES 
            (:title, :description, :video_link,:cuisine, :diet, :difficulty, :cooking_time, NOW())";

    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':title', $data['title']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':video_link', $data['video_file']); 
    $stmt->bindParam(':cuisine', $data['cuisine']);
    $stmt->bindParam(':diet', $data['diet']);
    $stmt->bindParam(':difficulty', $data['difficulty']);
    $stmt->bindParam(':cooking_time', $data['cooking_time']);

    return $stmt->execute();
}

    public function addinfo($data) {
    $sql = "INSERT INTO culinary_resources_infographics 
            (title, description,image)
            VALUES 
            (:title, :description, :image)";

    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':title', $data['title']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':image', $data['image']); 

    return $stmt->execute();
}
public function updateResourceById($id, $data) {
    $sql = "UPDATE educational_resources SET 
                title = :title,
                description = :description,
                type = :type,
                file_path = :file_path,
                cover_image = :cover_image
            WHERE id = :id";

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([
        'title' => $data['title'],
        'description' => $data['description'],
        'type' => $data['type'],
        'file_path' => $data['file_path'],
        'cover_image' => $data['cover_image'],
        'id' => $id
    ]);
}

public function updateHackByID($id, $data) {
    $sql = "UPDATE culinary_resources_hacks SET 
                title = :title,
                description = :description,
                video_link = :video_link
            WHERE id = :id";

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([
        'title' => $data['title'],
        'description' => $data['description'],
        'video_link' => $data['video_link'],
        'id' => $id
    ]);
}
public function getTutorialById($id) {
    $stmt = $this->connect()->prepare("SELECT * FROM culinary_resources_tutorials WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function updateTutorialById($id, $data) {
    $sql = "UPDATE culinary_resources_tutorials SET title = :title,description = :description, video_link = :video_link,
                cuisine = :cuisine, diet = :diet, difficulty = :difficulty, cooking_time = :cooking_time
            WHERE id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([
        'title' => $data['title'],
        'description' => $data['description'],
        'video_link' => $data['video_link'],
        'cuisine' => $data['cuisine'],
        'diet' => $data['diet'],
        'difficulty' => $data['difficulty'],
        'cooking_time' => $data['cooking_time'],
        'id' => $id
    ]);
}


public function deleteTutorialById($id) {
    $stmt = $this->connect()->prepare("DELETE FROM culinary_resources_tutorials WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

public function getAllTutorials() {
    $sql = "SELECT * FROM culinary_resources_tutorials ORDER BY created_at DESC";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getAllRecipeCards() {
    $stmt = $this->connect()->query("SELECT * FROM culinary_resources_recipe_cards ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getAllInfo() {
    $stmt = $this->connect()->query("SELECT * FROM culinary_resources_infographics ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get single card by ID
public function getRecipeCardById($id) {
    $stmt = $this->connect()->prepare("SELECT * FROM culinary_resources_recipe_cards WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function getInfoById($id) {
    $stmt = $this->connect()->prepare("SELECT * FROM culinary_resources_infographics WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Update card
public function updateRecipeCardById($id, $data) {
    $sql = "UPDATE culinary_resources_recipe_cards SET
                title = :title,
                description = :description,
                file_path = :file_path,
                cover_photo = :cover_photo,
                cuisine = :cuisine,
                diet = :diet,
                difficulty = :difficulty,
                cooking_time = :cooking_time
            WHERE id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(array_merge($data, ['id' => $id]));
}
public function updateinfobyid($id, $data) {
    $sql = "UPDATE culinary_resources_infographics SET
                title = :title,
                description = :description,
                image = :image
            WHERE id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(array_merge($data, ['id' => $id]));
}

public function deleteInfoById($id) {
    $stmt = $this->connect()->prepare("DELETE FROM culinary_resources_infographics WHERE id = :id");
    $stmt->execute(['id' => $id]);
}
// Delete card
public function deleteRecipeCard($id) {
    $stmt = $this->connect()->prepare("DELETE FROM culinary_resources_recipe_cards WHERE id = :id");
    $stmt->execute(['id' => $id]);
}



    public function getresbyid($id){
        $sql = "SELECT * FROM educational_resources WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function gethackbyid($id){
        $sql = "SELECT * FROM culinary_resources_hacks WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function gethacks(){
        $sql = "SELECT * FROM culinary_resources_hacks order by created_at";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Add Kitchen Hack
    public function addKitchenHack($data) {
        $sql = "INSERT INTO kitchen_hacks (title, description, image_path, postedby, is_approved, created_at)
                VALUES (:title, :description, :image_path, :postedby, :is_approved, NOW())";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($data);
    }

    public function getAllResources($table) {
        $sql = "SELECT * FROM $table ORDER BY created_at DESC";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function uploadCoverPhoto($fileInputName, $subFolder = 'resourceCovers/', $allowedTypes = ['jpg', 'jpeg', 'png'],
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


}