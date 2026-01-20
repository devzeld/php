<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <form action="../../../api/auth/login.php" method="POST">
        <h2>Login</h2>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Accedi</button>
        
        <div class="link-container">
            <a href="../register/register.html">Non hai un account? Registrati</a>
        </div>
    </form>
</body>
</html>