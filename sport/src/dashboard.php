<?php
session_start();
require_once __DIR__ . '/../../config/connect.php';

if (!isset($_SESSION['tessera_id'])) {
    header('Location: auth/login.php');
    exit;
}

$tessera_id = $_SESSION['tessera_id'];

$stmt = $pdo->prepare("SELECT * FROM soci WHERE tessera_id = ?");
$stmt->execute([$tessera_id]);
$socio = $stmt->fetch(PDO::FETCH_ASSOC);

$corsi = $pdo->query("SELECT c.codice_corso, c.descrizione, c.costo, c.giorni_settimana, c.ora_inizio, c.ora_fine,
                             i.descrizione AS impianto
                      FROM corsi c
                      JOIN impianti i ON c.codice_impianto = i.codice_impianto")
             ->fetchAll(PDO::FETCH_ASSOC);

$iscrizioni = $pdo->prepare("SELECT codice_corso FROM iscrizioni_corsi WHERE tessera_id = ?");
$iscrizioni->execute([$tessera_id]);
$iscritti = array_column($iscrizioni->fetchAll(PDO::FETCH_ASSOC), 'codice_corso');

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codice_corso'])) {
    $codice_corso = (int)$_POST['codice_corso'];

    $max = ($socio['tipo_socio'] === 'atleta') ? 2 : 3;
    if (count($iscritti) >= $max) {
        $message = "Hai raggiunto il limite massimo di corsi ({$max}).";
    } elseif (in_array($codice_corso, $iscritti)) {
        $message = "Sei già iscritto a questo corso.";
    } else {
        $pdo->prepare("INSERT INTO iscrizioni_corsi (tessera_id, codice_corso, data_iscrizione) VALUES (?, ?, CURDATE())")
            ->execute([$tessera_id, $codice_corso]);
        $message = "Iscrizione effettuata con successo!";
        $iscritti[] = $codice_corso;
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/global.css">
    <title>Dashboard</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="auth/logout.php">Esci</a></li>
            </ul>
        </nav>
    </header>

    <main style="max-width:700px;margin:30px auto">

        <section style="background:white;border-radius:10px;padding:24px;margin-bottom:24px;box-shadow:0 4px 16px rgba(0,0,0,.08)">
            <h2 style="margin-bottom:16px;color:#333">I tuoi dati</h2>
            <table style="width:100%;font-size:14px;border-collapse:collapse">
                <tr><td style="padding:6px 0;color:#888;width:40%">Tessera n°</td><td><?= $socio['tessera_id'] ?></td></tr>
                <tr><td style="padding:6px 0;color:#888">Nome</td><td><?= htmlspecialchars($socio['nome'] . ' ' . $socio['cognome']) ?></td></tr>
                <tr><td style="padding:6px 0;color:#888">Email</td><td><?= htmlspecialchars($socio['email']) ?></td></tr>
                <tr><td style="padding:6px 0;color:#888">Indirizzo</td><td><?= htmlspecialchars($socio['indirizzo']) ?></td></tr>
                <tr><td style="padding:6px 0;color:#888">Data di nascita</td><td><?= $socio['data_nascita'] ?></td></tr>
                <tr><td style="padding:6px 0;color:#888">Tipo socio</td><td><?= ucfirst($socio['tipo_socio']) ?></td></tr>
            </table>
        </section>

        <section style="background:white;border-radius:10px;padding:24px;box-shadow:0 4px 16px rgba(0,0,0,.08)">
            <h2 style="margin-bottom:16px;color:#333">Corsi disponibili</h2>

            <?php if ($message): ?>
                <p style="background:#f0fdf4;border:1px solid #86efac;padding:10px;border-radius:6px;margin-bottom:16px;font-size:14px">
                    <?= $message ?>
                </p>
            <?php endif; ?>

            <?php foreach ($corsi as $corso): ?>
            <div style="border:1px solid #eee;border-radius:8px;padding:16px;margin-bottom:12px">
                <strong><?= htmlspecialchars($corso['descrizione']) ?></strong>
                <div style="font-size:13px;color:#666;margin:6px 0">
                    📍 <?= htmlspecialchars($corso['impianto']) ?> &nbsp;|&nbsp;
                    📅 <?= $corso['giorni_settimana'] ?> &nbsp;|&nbsp;
                    🕐 <?= substr($corso['ora_inizio'],0,5) ?>–<?= substr($corso['ora_fine'],0,5) ?> &nbsp;|&nbsp;
                    💶 €<?= number_format($corso['costo'],2) ?>
                </div>
                <?php if (in_array($corso['codice_corso'], $iscritti)): ?>
                    <span style="font-size:13px;color:#16a34a;font-weight:600">✔ Iscritto</span>
                <?php else: ?>
                    <form method="POST" style="margin:0">
                        <input type="hidden" name="codice_corso" value="<?= $corso['codice_corso'] ?>">
                        <button type="submit" style="margin-top:8px;padding:8px 16px;width:auto;font-size:13px">Iscriviti</button>
                    </form>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </section>

    </main>
</body>
</html>