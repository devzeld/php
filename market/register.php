<?php
$pdo = require_once "./connect.php";

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
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <title>Registrazione</title>
</head>
<body>

    <form action="register.php" method="POST">
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

        <button onclick="document.location.href = '<?php echo "index.php"; ?>'; type="submit">Register User</button>
        <button onclick="document.location.href = '<?php echo "login.php"; ?>';">Ho già un account</button>
    </form>
</body>
</html>

