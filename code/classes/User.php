<?php
require_once 'Database.php';

class User extends Database {
    public function create($username, $password, $email, $telefoon) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (UserName, UserPassword, email, telefoonnumer) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $hash, $email, $telefoon]);
    }

    public function read($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($id, $username, $email, $telefoon) {
        $stmt = $this->pdo->prepare("UPDATE users SET UserName = ?, email = ?, telefoonnumer = ? WHERE ID = ?");
        return $stmt->execute([$username, $email, $telefoon, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE ID = ?");
        return $stmt->execute([$id]);
    }

    public function findByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE UserName = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
}