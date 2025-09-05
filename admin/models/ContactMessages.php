<?php
namespace AdminModel;
use PDO;
use db\Database;

class ContactMessages extends Database {
    public function getAllMessages() {
        $sql = "SELECT * FROM contact_messages ORDER BY submitted_at DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>