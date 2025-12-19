<?php
    session_start();

    if (isset($_SESSION["username"])) {
        header("Location: register.php");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Market</title>
</head>
<body>
    <main>
        <div>
            <button onclick="document.location.href = '<?php echo "register.php"; ?>';">Register</button>
            <button onclick="document.location.href = '<?php echo "login.php"; ?>';">Accedi</button>
        </div>
    </main>
</body>
</html>
