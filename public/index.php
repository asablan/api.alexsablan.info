<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;
use App\Controllers\AuthController;
use App\Utils\Response;

$database = new Database();
$db = $database->connect();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', trim($uri, '/'));
$method = $_SERVER['REQUEST_METHOD'];

if ($uri[0] === 'register' && $method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    (new AuthController($db))->register($data);
} elseif ($uri[0] === 'login' && $method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    (new AuthController($db))->login($data);
} else {
    Response::json(['error' => 'Invalid endpoint or method'], 404);
}