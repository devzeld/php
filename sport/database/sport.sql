CREATE DATABASE IF NOT EXISTS sport;
USE sport;

CREATE TABLE soci (
    tessera_id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    indirizzo VARCHAR(100) NOT NULL,
    data_nascita DATE NOT NULL,
    professione VARCHAR(50),
    tipo_socio ENUM('atleta', 'frequentatore', 'onorario') NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    data_iscrizione TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE atleti (
    tessera_id INT PRIMARY KEY,
    data_ultima_visita DATE,
    data_tessera_federativa DATE,
    sport_individuale VARCHAR(50),
    FOREIGN KEY (tessera_id) REFERENCES soci(tessera_id) ON DELETE CASCADE
);

CREATE TABLE frequentatori (
    tessera_id INT PRIMARY KEY,
    corsi_ultimi_5anni INT DEFAULT 0,
    FOREIGN KEY (tessera_id) REFERENCES soci(tessera_id) ON DELETE CASCADE
);

CREATE TABLE soci_onorari (
    tessera_id INT PRIMARY KEY,
    ruolo VARCHAR(100) NOT NULL,
    FOREIGN KEY (tessera_id) REFERENCES soci(tessera_id) ON DELETE CASCADE
);

CREATE TABLE impianti (
    codice_impianto INT PRIMARY KEY AUTO_INCREMENT,
    descrizione VARCHAR(100) NOT NULL,
    indirizzo VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    ente_gestore VARCHAR(100)
);

CREATE TABLE responsabili (
    codice_fiscale VARCHAR(16) PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    telefono VARCHAR(20),
    indirizzo VARCHAR(100),
    paga_oraria DECIMAL(6,2)
);

CREATE TABLE corsi (
    codice_corso INT PRIMARY KEY AUTO_INCREMENT,
    descrizione VARCHAR(200) NOT NULL,
    costo DECIMAL(8,2) NOT NULL,
    giorni_settimana SET('lunedi','martedi','mercoledi','giovedi','venerdi','sabato','domenica') NOT NULL,
    ora_inizio TIME NOT NULL,
    ora_fine TIME NOT NULL,
    codice_impianto INT NOT NULL,
    responsabile_cf VARCHAR(16) NOT NULL,
    max_partecipanti INT DEFAULT 20,
    FOREIGN KEY (codice_impianto) REFERENCES impianti(codice_impianto),
    FOREIGN KEY (responsabile_cf) REFERENCES responsabili(codice_fiscale)
);

CREATE TABLE iscrizioni_corsi (
    id_iscrizione INT PRIMARY KEY AUTO_INCREMENT,
    tessera_id INT NOT NULL,
    codice_corso INT NOT NULL,
    data_iscrizione DATE NOT NULL,
    pagamento_effettuato BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (tessera_id) REFERENCES soci(tessera_id) ON DELETE CASCADE,
    FOREIGN KEY (codice_corso) REFERENCES corsi(codice_corso) ON DELETE CASCADE,
    UNIQUE KEY (tessera_id, codice_corso)
);

CREATE TABLE allenatori (
    codice_allenatore INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    data_tessera_federativa DATE NOT NULL
);

CREATE TABLE squadre (
    id_squadra INT PRIMARY KEY AUTO_INCREMENT,
    nome_squadra VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    numero_titolari INT NOT NULL,
    codice_allenatore INT NOT NULL,
    FOREIGN KEY (codice_allenatore) REFERENCES allenatori(codice_allenatore)
);

CREATE TABLE atleti_squadre (
    tessera_id INT NOT NULL,
    id_squadra INT NOT NULL,
    anno_ingresso YEAR NOT NULL,
    PRIMARY KEY (tessera_id, id_squadra),
    FOREIGN KEY (tessera_id) REFERENCES atleti(tessera_id) ON DELETE CASCADE,
    FOREIGN KEY (id_squadra) REFERENCES squadre(id_squadra) ON DELETE CASCADE
);

INSERT INTO impianti (descrizione, indirizzo, telefono, ente_gestore) VALUES
('Palestra Centrale', 'Via Roma 15, Milano', '02-12345678', 'Comune di Milano'),
('Campo Sportivo Nord', 'Via Monza 100, Milano', '02-87654321', 'Provincia di Milano'),
('Piscina Comunale', 'Viale Europa 50, Milano', '02-11223344', 'Comune di Milano');

INSERT INTO responsabili (codice_fiscale, nome, cognome, telefono, indirizzo, paga_oraria) VALUES
('RSSMRA80A01F205X', 'Mario', 'Rossi', '333-1234567', 'Via Verdi 10, Milano', 25.00),
('BNCLRA85B15F205Y', 'Laura', 'Bianchi', '333-7654321', 'Via Dante 20, Milano', 30.00),
('VRDGPP75C10F205Z', 'Giuseppe', 'Verdi', '333-9876543', 'Via Manzoni 5, Milano', 28.00);

INSERT INTO corsi (descrizione, costo, giorni_settimana, ora_inizio, ora_fine, codice_impianto, responsabile_cf) VALUES
('Calcio Base', 150.00, 'lunedi,mercoledi,venerdi', '18:00:00', '19:30:00', 2, 'RSSMRA80A01F205X'),
('Pallavolo Avanzata', 180.00, 'martedi,giovedi', '19:00:00', '20:30:00', 1, 'BNCLRA85B15F205Y'),
('Nuoto Principianti', 200.00, 'lunedi,mercoledi', '17:00:00', '18:00:00', 3, 'VRDGPP75C10F205Z'),
('Fitness e Tonificazione', 120.00, 'lunedi,mercoledi,venerdi', '19:00:00', '20:00:00', 1, 'BNCLRA85B15F205Y'),
('Basket Giovanile', 160.00, 'martedi,giovedi,sabato', '16:00:00', '17:30:00', 1, 'RSSMRA80A01F205X');

INSERT INTO allenatori (nome, cognome, data_tessera_federativa) VALUES
('Carlo', 'Martini', '2023-01-15'),
('Anna', 'Ferrari', '2022-09-10'),
('Luca', 'Conti', '2024-03-20');

INSERT INTO squadre (nome_squadra, categoria, numero_titolari, codice_allenatore) VALUES
('Tigers Under 18', 'Giovanile', 11, 1),
('Eagles Senior', 'Senior', 12, 2),
('Dolphins Junior', 'Junior', 10, 3);

-- Account admin di default (password: admin123)
INSERT INTO soci (nome, cognome, indirizzo, data_nascita, professione, tipo_socio, email, password) VALUES
('Admin', 'Sistema', 'Via Amministrazione 1', '1980-01-01', 'Amministratore', 'onorario', 'admin@tuttiinforma.it', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO soci_onorari (tessera_id, ruolo) VALUES (1, 'Amministratore di Sistema');