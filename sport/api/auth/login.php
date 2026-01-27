<?php
session_start();
require_once __DIR__ . '/../../config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;

    try {
        $stmt = $pdo->prepare("SELECT id, email, password FROM soci WHERE email = ?");
        $stmt->execute([$data['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($data['password'], $user['password'])) {
            $_SESSION['tessera_id'] = $user['tessera_id'];
            header('Location:../../src/index.php');
            exit;
        } else {
            header('Location:../../src/auth/login.php');
            exit;
        }
    } catch (PDOException $e) {
        echo 'Login failed ' . $e;
    }
}
