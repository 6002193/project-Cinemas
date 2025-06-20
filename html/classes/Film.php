<?php
require_once 'Database.php';

class Film extends Database {
    public function create($naam, $rating, $room, $seats, $foto_url) {
        $stmt = $this->pdo->prepare("INSERT INTO movies (naam, rating, room, seats, foto_url) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$naam, $rating, $room, $seats, $foto_url]);
    }

    public function readAll() {
        $stmt = $this->pdo->query("SELECT * FROM movies");
        return $stmt->fetchAll();
    }

    public function updateRoom($id, $room) {
        $stmt = $this->pdo->prepare("UPDATE movies SET room = ? WHERE id = ?");
        return $stmt->execute([$room, $id]);
    }

    public function delete($naam) {
        $stmt = $this->pdo->prepare("DELETE FROM movies WHERE naam = ?");
        return $stmt->execute([$naam]);
    }
}