<?php
require_once __DIR__ . '/../../config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['username']) || !isset($data['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'username and password are required']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT id, email, password FROM soci WHERE email = ?");
        $stmt->execute([$data['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($data['password'], $user['password'])) {
            
            exit;
        }
    } catch (PDOException $e) {
        echo 'Login failed';
    }
}
