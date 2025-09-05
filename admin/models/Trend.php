<?php

namespace AdminModel;
use PDO;
use db\Database;
use PDOException;
class Trend extends Database
{
  public function getAll() {
        $stmt = $this->connect()->query("SELECT * FROM culinary_trends");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM culinary_trends WHERE trend_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } 

    public function deleteTrend($id) {
        $sql = "DELETE FROM culinary_trends WHERE trend_id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function createCulinaryTrend($data)
    {
        try {
        $conn = $this->connect();
        $sql = "INSERT INTO culinary_trends (trend_title, trend_description, trend_image, created_at) VALUES(:trend_title, :trend_description, :trend_image, Now())";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':trend_title', $data['trend_title']);
        $stmt->bindParam(':trend_description', $data['trend_description']);
        $stmt->bindParam(':trend_image', $data['trend_image']);
        if ($stmt->execute()) {
            return $conn->lastInsertId(); 
        }
        return false;
        } 
        catch (PDOException $e) {
            error_log("Insert culinary trend failed: " . $e->getMessage());
            return false;
        }
    }

    public function update($id, $title, $description, $image, $createdAt) {
        $stmt = $this->connect()->prepare("UPDATE culinary_trends SET trend_title = :title, trend_description = :description, trend_image = :image, created_at = :createdAt WHERE trend_id = :id");
        $stmt->execute([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'image' => $image,
            'createdAt' => $createdAt
        ]);
    }

    
    public function uploadCulinaryTrendImage($fileInputName, $subFolder = 'trends/', $allowedTypes = ['jpg', 'jpeg', 'png'],
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
?>