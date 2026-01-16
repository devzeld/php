    <?php
    require_once './config/connect.php';

    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        $data = json_encode(file_get_contents('php://input'), true);

        try {
            $stmt = $pdo->prepare("SELECT nome FROM soci WHERE nome = ?");
            $stmt->execute([$data['nome']]);
            $socio = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$socio) {
                $stmt = $pdo->prepare("INSERT (nome, cognome, indirizzo, data_nascita, professione, tipo_socio, email) FROM soci WHERE nome = ?");
                $hashed_password = password_hash($data['password'], PASSWORD_BCRYPT);

                $stmt->execute([$data['nome']]);
            }
        } catch (PDOException $e) {
            echo "Error: " . $e;
        }
    }
