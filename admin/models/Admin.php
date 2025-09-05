<?php

namespace AdminModel;
use PDO;
use db\Database;
use PDOException;
class Admin extends Database
{
    public function exists($field, $value) {
        $sql = "SELECT COUNT(*) FROM recipes WHERE $field = :value";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function register($data) {
        $sql = "INSERT INTO users (first_name,last_name, username, email, password,role) VALUES (:first_name, :last_name, :username, :email, :password,:role)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $hashedPassword = password_hash($data['password'],PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashedPassword);
        $role = 'admin';
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    public function findByUsernameOrEmail($identifier){
        $sql = 'SELECT * FROM users WHERE (username = :id OR email = :id) AND role = "admin" LIMIT 1';
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['id' => $identifier]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function recordLoginAttempt($userid, $identifier, $ip, $success)
    {
        $sql = "INSERT INTO login_attempts (user_id, identifier, ip_address, success)
                VALUES (:user_id, :identifier, :ip, :success)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            'user_id' => $userid,
            'identifier' => $identifier,
            'ip' => $ip,
            'success' => $success ? 1 : 0
        ]);
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
    public function countRecentFailedAttempts($identifier, $minutes = 3) 
    {
        $sql = "SELECT COUNT(*) FROM login_attempts WHERE identifier = :identifier AND success = 0 AND attempted_at >= NOW() - INTERVAL :minutes MINUTE";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue('identifier', $identifier);
        $stmt->bindValue('minutes', $minutes, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function getLastFailedAttemptTime($identifier) {
        $sql = "
            SELECT attempted_at 
            FROM login_attempts 
            WHERE identifier = :identifier 
            AND success = 0 
            ORDER BY attempted_at DESC 
            LIMIT 1
        ";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(':identifier', $identifier);
        $stmt->execute();
        return $stmt->fetchColumn(); 
    }

    public function getAllUsers(){
    $stmt = $this->connect()->prepare("SELECT * FROM users where role = 'user' ORDER BY created_at DESC ");
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

  public function deleteUsersById($userId) {
    $db = $this->connect();
    $stmt = $db->prepare("DELETE FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $userId);
    return $stmt->execute();
}


    public function getUserCount() {
        $stmt = $this->connect()->query("SELECT COUNT(*) FROM users");
        return $stmt->fetchColumn();
    }

    public function getRecipeCount() {
        $stmt = $this->connect()->query("SELECT COUNT(*) FROM recipes");
        return $stmt->fetchColumn();
    }

    public function getContactMessageCount() {
        $stmt = $this->connect()->query("SELECT COUNT(*) FROM contact_messages");
        return $stmt->fetchColumn();
    }

    public function getUpcomingEvents($limit = 5) {
        $stmt = $this->connect()->prepare("SELECT * FROM events WHERE event_date >= NOW() ORDER BY event_date ASC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentRecipes($limit = 5) {
        $stmt = $this->connect()->prepare("SELECT * FROM recipes ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>