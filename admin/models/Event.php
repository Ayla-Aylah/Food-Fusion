<?php

namespace AdminModel;
use db\Database;
use PDO;

class Event extends Database
{
    public function getAllEvents()
    {
        $sql = "SELECT * FROM events ORDER BY event_date ASC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEvent($data)
    {
        $sql = "INSERT INTO events (title, description, event_image, event_date, location, registration_link)
                VALUES (:title, :description, :event_image, :event_date, :location, :registration_link)";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute($data);
    }

    public function getEventById($id)
    {
        $sql = "SELECT * FROM events WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateEvent($data)
    {
        $sql = "UPDATE events SET title = :title, description = :description, event_image = :event_image,
                event_date = :event_date, location = :location, registration_link = :registration_link
                WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute($data);
    }

    public function deleteEvent($id)
    {
        $sql = "DELETE FROM events WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}

?>