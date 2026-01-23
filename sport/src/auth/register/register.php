<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <title>Register</title>
</head>

<body>
    <form action="../../../api/auth/registration.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome">

        <label for="cognome">Cognome:</label>
        <input type="text" id="cognome" name="cognome">

        <label for="indirizzo">Indirizzo:</label>
        <input type="text" id="indirizzo" name="indirizzo">

        <label for="data_nascita">Data di nascita:</label>
        <input type="date" id="data_nascita" name="data_nascita">

        <label for="professione">Professione:</label>
        <input type="text" id="professione" name="professione">

        <label for="tipo_socio">Tipo socio:</label>
        <input type="text" id="tipo_socio" name="tipo_socio">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">

        <button type="submit">Invia dati</button>
    </form>
</body>

</html>