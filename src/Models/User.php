<?php
namespace App\Models;

use PDO;
use PDOException;

class User {
    private $conn;
    private $table = 'api_users';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($data) {
        $query = "INSERT INTO " . $this->table . " (username, password_hash, fname, lname, email, cellphone)
                  VALUES (:username, :password_hash, :fname, :lname, :email, :cellphone)";
        $stmt = $this->conn->prepare($query);
        $hashed = password_hash($data['password'], PASSWORD_BCRYPT);

        try {
            $stmt->execute([
                ':username' => $data['username'],
                ':password_hash' => $hashed,
                ':fname' => $data['fname'],
                ':lname' => $data['lname'],
                ':email' => $data['email'],
                ':cellphone' => $data['cellphone']
            ]);
            return ['message' => 'User registered successfully', 'status' => 201];
        } catch (PDOException $e) {
            return ['error' => 'Registration failed: ' . $e->getMessage(), 'status' => 400];
        }
    }

    public function login($data) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':username' => $data['username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($data['password'], $user['password_hash'])) {
            return ['message' => 'Login successful', 'user' => $user, 'status' => 200];
        }

        return ['error' => 'Invalid credentials', 'status' => 401];
    }
}
