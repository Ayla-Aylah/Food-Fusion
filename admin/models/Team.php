<?php
namespace AdminModel;
use db\Database;
use PDO;

class Team extends Database {

    public function getAll() {
        $stmt = $this->connect()->query("SELECT * FROM team_members");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

 
    public function add($data) {
        $stmt = $this->connect()->prepare("INSERT INTO team_members (name, position, photo, email) VALUES (:name, :position, :photo, :email)");
        return $stmt->execute($data);
    }

    public function update($id, $data) {
    $stmt = $this->connect()->prepare("UPDATE team_members SET name = :name, position = :position, photo = :photo, email = :email WHERE id = :id");
    $stmt->execute([
        'id' => $id,
        'name' => $data['name'],
        'position' =>$data['position'],
        'photo' => $data['photo'],
        'email' => $data['email']
    ]);

    }

    public function delete($id) {
        $stmt = $this->connect()->prepare("DELETE FROM team_members WHERE id = ?");
        return $stmt->execute([$id]);
    }
            public function getById($id)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM team_members WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } 
    public function deleteMemberByID($id) {
    $sql = "DELETE FROM team_members WHERE id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
    
}