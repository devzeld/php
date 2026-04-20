<?php
require_once __DIR__ . '/../../config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        echo 'Email, username and password are required';
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT email FROM soci WHERE email = ?");
        $stmt->execute([$_POST['email']]);
        $socio = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$socio) {
            $stmt = $pdo->prepare("INSERT INTO soci (nome, cognome, indirizzo, data_nascita, professione, tipo_socio, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $stmt->execute([
                $_POST['nome'],
                $_POST['cognome'],
                $_POST['indirizzo'],
                $_POST['data_nascita'],
                $_POST['professione'],
                $_POST['tipo_socio'],
                $_POST['email'],
                $hashed_password
            ]);

            header("Location: ../../src/auth/login.php");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e;
    }
}
