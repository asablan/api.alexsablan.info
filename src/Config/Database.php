<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    private $host = 'mysqlapi.trackit.alexsablan.info';
    private $db_name = 'trackit_alexsablan_info';
    private $username = 'trackitalexsabla';
    private $password = 'Q_funk2424!';
    public $conn;

    public function connect() {
        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch(PDOException $e) {
            echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
            exit;
        }
    }
}