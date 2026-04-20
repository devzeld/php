CREATE DATABASE IF NOT EXISTS supermercato;
USE supermercato;

CREATE TABLE PUNTO_VENDITA (
    id_punto        INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    localita        VARCHAR(100) NOT NULL,
    indirizzo       VARCHAR(150) NOT NULL,
    responsabile    VARCHAR(80)  NOT NULL,
    num_dipendenti  INT          NOT NULL DEFAULT 0
);

CREATE TABLE FORNITORE (
    codice_fiscale  VARCHAR(16)  NOT NULL PRIMARY KEY,
    nome            VARCHAR(100) NOT NULL,
    sede            VARCHAR(150) NOT NULL
);

CREATE TABLE PRODOTTO (
    id_prodotto             INT            NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descrizione             VARCHAR(150)   NOT NULL,
    casa_produttrice        VARCHAR(100)   NOT NULL,
    prezzo_vendita          DECIMAL(8,2)   NOT NULL,
    codice_fiscale_fornitore VARCHAR(16)   NOT NULL,
    FOREIGN KEY (codice_fiscale_fornitore) REFERENCES FORNITORE(codice_fiscale)
);

CREATE TABLE APPROVVIGIONAMENTO (
    id_approv   INT  NOT NULL PRIMARY KEY AUTO_INCREMENT,
    data        DATE NOT NULL,
    id_punto    INT  NOT NULL,
    FOREIGN KEY (id_punto) REFERENCES PUNTO_VENDITA(id_punto)
);

CREATE TABLE DETTAGLIO_APPROV (
    id_approv   INT NOT NULL,
    id_prodotto INT NOT NULL,
    quantita    INT NOT NULL DEFAULT 1,
    PRIMARY KEY (id_approv, id_prodotto),
    FOREIGN KEY (id_approv)   REFERENCES APPROVVIGIONAMENTO(id_approv),
    FOREIGN KEY (id_prodotto) REFERENCES PRODOTTO(id_prodotto)
);

INSERT INTO PUNTO_VENDITA (localita, indirizzo, responsabile, num_dipendenti) VALUES
('Milano',  'Via Roma 10',      'Mario Rossi',    25),
('Torino',  'Corso Duca 55',    'Laura Bianchi',  18),
('Venezia', 'Piazza San Marco', 'Carlo Verdi',    12);

INSERT INTO FORNITORE (codice_fiscale, nome, sede) VALUES
('FRNLGI80A01H501X', 'Alimentari del Nord Srl',  'Milano'),
('GRNMRC75B15F205Y', 'Fresco Distribuzione Spa', 'Bologna'),
('VRDPLA70C20L219Z', 'Sud Sapori Cooperativa',   'Napoli');

INSERT INTO PRODOTTO (descrizione, casa_produttrice, prezzo_vendita, codice_fiscale_fornitore) VALUES
('Pasta di semola 500g',    'Barilla',       1.20, 'FRNLGI80A01H501X'),
('Passata di pomodoro 700g','Mutti',         1.80, 'GRNMRC75B15F205Y'),
('Olio extravergine 1L',    'Carapelli',     4.50, 'VRDPLA70C20L219Z'),
('Latte intero 1L',         'Parmalat',      1.35, 'FRNLGI80A01H501X'),
('Farina 00 1kg',           'Molino Chiavazza', 0.95, 'GRNMRC75B15F205Y'),
('Acqua minerale 1.5L',     'San Pellegrino',0.55, 'FRNLGI80A01H501X');

INSERT INTO APPROVVIGIONAMENTO (data, id_punto) VALUES
('2024-03-01', 1),
('2024-03-05', 2),
('2024-03-10', 3);

INSERT INTO DETTAGLIO_APPROV (id_approv, id_prodotto, quantita) VALUES
(1, 1, 200), (1, 2, 150), (1, 4, 100),
(2, 1, 100), (2, 3,  80), (2, 5, 120),
(3, 2,  60), (3, 4,  90), (3, 6, 200);