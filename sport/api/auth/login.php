<?php
require_once __DIR__ . '/../../config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    try {
        $stmt = $pdo->prepare("SELECT id, email, password FROM soci WHERE email = ?");
        $stmt->execute([$data['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($data['password'], $user['password'])) {
            $_SESSION['id'] = $rows[0]['id'];
            header('Location:../../src/index.php');
            exit;
        } else {
            header('Location:login.php');
        }
    } catch (PDOException $e) {
        echo 'Login failed';
    }
}
