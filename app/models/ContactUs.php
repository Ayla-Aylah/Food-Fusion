<?php
namespace Model;
use PDO;
use db\Database;
use PDOException;
class ContactUs extends Database{
    public function storeContact($data){
         $sql = "INSERT INTO contact_messages(full_name, email, subject , message) VALUES (:full_name, :email, :subject , :message)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':full_name', $data['full_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':subject', $data['messageType']);
        $stmt->bindParam(':message', $data['message']);
        return $stmt->execute();
    }

}

?>