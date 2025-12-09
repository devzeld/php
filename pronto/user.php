<?php
$pdo = require_once "assets/php/connect.php";

function input_user_data($pdo) {
    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        $username = $_POST['username'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];

        $sql = "INSERT INTO users (username, name, surname) VALUES (:username, :name, :surname)";
        $stmt = $pdo -> prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':name' => $name,
            ':surname' => $surname
        ]);
    }
}
echo input_user_data($pdo);
