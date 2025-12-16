<form action="" method="POST">
  <label for="email">Email:</label>
  <input type="email" id="mail" name="mail" required />

  <label for="username">Username:</label>
  <input type="text" id="username" name="username" required />

  <label for="name">Name:</label>
  <input type="text" id="name" name="name" />

  <label for="surname">Surname:</label>
  <input type="text" id="surname" name="surname" />

  <label for="password">Password:</label>
  <input type="password" id="password" name="password" required />

  <button type="submit">Register User</button>
</form>

<?php
$pdo = require_once "assets/php/connect.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $mail = $_POST['mail'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (mail, username, name, surname, password, create_time) VALUES (:mail, :username, :name, :surname, :password, NOW())";
    $stmt = $pdo -> prepare($sql);
    $stmt->execute([
        ':mail'=>$mail,
        ':username' => $username,
        ':name' => $name,
        ':surname' => $surname,
        ':password' => $password
    ]);

    $_SESSION["username"] = $username;
}
?>
