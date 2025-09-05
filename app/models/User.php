<?php

namespace Model;
use PDO;
use db\Database;

class User extends Database
{
    public function exists($field, $value) {
        $sql = "SELECT COUNT(*) FROM users WHERE $field = :value";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function register($data) {
        $sql = "INSERT INTO users (first_name,last_name, username, email, password,role) 
        VALUES (:first_name, :last_name, :username, :email, :password,:role)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $hashedPassword = password_hash($data['password'],PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashedPassword);
        $role = 'user';
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    public function findByUsernameOrEmail($identifier){
        $sql = 'SELECT * FROM users WHERE (username = :id OR email = :id) AND role = "user" LIMIT 1';
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['id' => $identifier]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function recordLoginAttempt($userId, $identifier, $ip, $success)
    {
        $sql = "INSERT INTO login_attempts (user_id, identifier, ip_address, success) 
                VALUES (:user_id, :identifier, :ip, :success)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT); 
        $stmt->bindValue(':identifier', $identifier);
        $stmt->bindValue(':ip', $ip);
        $stmt->bindValue(':success', $success ? 1 : 0, PDO::PARAM_BOOL);
        $stmt->execute();
    }

    public function countRecentFailedAttempts($minutes = 3) 
    {
        $sql = "SELECT COUNT(*) FROM login_attempts WHERE success = 0 AND attempted_at >= NOW() - INTERVAL :minutes MINUTE";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue('minutes', $minutes, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    public function getLastFailedAttemptTime() {
        $sql = "
            SELECT attempted_at FROM login_attempts WHERE success = 0 ORDER BY attempted_at DESC LIMIT 1
        ";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn(); 
    }

    public function findById($id) {
    $sql = "SELECT id, profile_image, first_name, last_name, username, email, role, created_at FROM users WHERE id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $fields) {
        $sql = "UPDATE users SET ";
        $params = [];

        foreach ($fields as $key => $value) {
            $sql .= "$key = :$key, ";
            $params[$key] = $value;
        }

        $sql = rtrim($sql, ', ') . " WHERE id = :id";
        $params['id'] = $id;

        $stmt = $this->connect()->prepare($sql);

        foreach ($params as $param => $value) {
            $stmt->bindValue(':' . $param, $value);
        }
        return $stmt->execute();
    }

    public function uploadProfileImage($fileInputName, $subFolder = 'profile/', $allowedTypes = ['jpg', 'jpeg', 'png'], $maxSize = 2 * 1024 * 1024)
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
    $destinationPath = $uploadDir . $uniqueFileName;
    // Move the uploaded file to the destination path
    if (move_uploaded_file($fileTmpPath, $destinationPath)) {
        return ['path' => '/uploads/' . $subFolder . $uniqueFileName];
    } else {
        return ['error' => 'Failed to move uploaded file.'];
    }
}
    public function deleteById($id) {
    
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }  

    public function getMembers() {
        $stmt = $this->connect()->prepare("SELECT * FROM team_members ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}




?>