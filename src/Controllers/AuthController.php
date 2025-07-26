<?php
namespace App\Controllers;

use App\Models\User;
use App\Utils\Response;

class AuthController {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function register($data) {
        $user = new User($this->db);
        $result = $user->register($data);
        Response::json($result, $result['status']);
    }

    public function login($data) {
        $user = new User($this->db);
        $result = $user->login($data);
        Response::json($result, $result['status']);
    }
}