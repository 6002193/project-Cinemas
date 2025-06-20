<?php
require_once 'Database.php';

class Reservering extends Database {
    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO reserveringen (locatie, datum, tijd, aantal, naam, email, telefoon, film, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['locatie'],
            $data['datum'],
            $data['tijd'],
            $data['aantal'],
            $data['naam'],
            $data['email'],
            $data['telefoon'],
            $data['film'],
            $data['user_id']
        ]);
    }

    public function readAll() {
        $stmt = $this->pdo->query("SELECT * FROM reserveringen ORDER BY datum DESC, tijd DESC");
        return $stmt->fetchAll();
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM reserveringen WHERE id = ?");
        return $stmt->execute([$id]);
    }
}