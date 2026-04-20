CREATE DATABASE IF NOT EXISTS orario_lezioni;
USE orario_lezioni;

CREATE TABLE AULA (
    codice_aula          VARCHAR(10)  NOT NULL PRIMARY KEY,
    num_posti            INT          NOT NULL,
    edificio             VARCHAR(50)  NOT NULL,
    ha_lavagna_digitale  BOOLEAN      NOT NULL DEFAULT FALSE
);

CREATE TABLE AULA_COMPUTER (
    codice_aula      VARCHAR(10) NOT NULL PRIMARY KEY,
    num_calcolatori  INT         NOT NULL,
    FOREIGN KEY (codice_aula) REFERENCES AULA(codice_aula) ON DELETE CASCADE
);

CREATE TABLE PROGRAMMA (
    id_programma    INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome_programma  VARCHAR(100) NOT NULL
);

CREATE TABLE INSTALLAZIONE (
    codice_aula   VARCHAR(10) NOT NULL,
    id_programma  INT         NOT NULL,
    PRIMARY KEY (codice_aula, id_programma),
    FOREIGN KEY (codice_aula)  REFERENCES AULA_COMPUTER(codice_aula),
    FOREIGN KEY (id_programma) REFERENCES PROGRAMMA(id_programma)
);

CREATE TABLE CORSO (
    codice_corso  VARCHAR(10)  NOT NULL PRIMARY KEY,
    nome          VARCHAR(100) NOT NULL,
    docente       VARCHAR(80)  NOT NULL
);

CREATE TABLE LEZIONE (
    id_lezione       INT         NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ora_inizio       TIME        NOT NULL,
    ora_fine         TIME        NOT NULL,
    giorno_settimana ENUM('Lunedì','Martedì','Mercoledì','Giovedì','Venerdì') NOT NULL,
    semestre         TINYINT     NOT NULL CHECK (semestre IN (1, 2)),
    codice_aula      VARCHAR(10) NOT NULL,
    codice_corso     VARCHAR(10) NOT NULL,
    FOREIGN KEY (codice_aula)  REFERENCES AULA(codice_aula),
    FOREIGN KEY (codice_corso) REFERENCES CORSO(codice_corso)
);

-- Dati di esempio
INSERT INTO AULA VALUES
('A1', 60, 'Edificio A', TRUE),
('B3', 30, 'Edificio B', FALSE),
('LAB1', 20, 'Edificio C', TRUE);

INSERT INTO AULA_COMPUTER VALUES ('LAB1', 20);
INSERT INTO PROGRAMMA (nome_programma) VALUES ('Visual Studio Code'), ('MATLAB'), ('MySQL Workbench');
INSERT INTO INSTALLAZIONE VALUES ('LAB1', 1), ('LAB1', 3);

INSERT INTO CORSO VALUES
('INF01', 'Basi di Dati',        'Prof. Colombo'),
('MAT02', 'Analisi Matematica',  'Prof.ssa Ferrari'),
('PRG03', 'Programmazione Web',  'Prof. Ricci');

INSERT INTO LEZIONE (ora_inizio, ora_fine, giorno_settimana, semestre, codice_aula, codice_corso) VALUES
('09:00', '11:00', 'Lunedì',    1, 'A1',   'INF01'),
('11:00', '13:00', 'Mercoledì', 1, 'LAB1', 'INF01'),
('08:00', '10:00', 'Martedì',   1, 'B3',   'MAT02'),
('14:00', '16:00', 'Giovedì',   2, 'A1',   'PRG03');

CREATE DATABASE IF NOT EXISTS musei_arte;
USE musei_arte;

CREATE TABLE MUSEO (
    nome       VARCHAR(100) NOT NULL PRIMARY KEY,
    citta      VARCHAR(80)  NOT NULL,
    indirizzo  VARCHAR(150) NOT NULL,
    direttore  VARCHAR(80)  NOT NULL
);

CREATE TABLE ARTISTA (
    nome          VARCHAR(100) NOT NULL PRIMARY KEY,
    nazionalita   VARCHAR(50)  NOT NULL,
    data_nascita  DATE         NOT NULL,
    data_morte    DATE
);

CREATE TABLE OPERA (
    codice          INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    titolo          VARCHAR(150) NOT NULL,
    anno_creazione  YEAR         NOT NULL,
    nome_museo      VARCHAR(100) NOT NULL,
    nome_artista    VARCHAR(100) NOT NULL,
    FOREIGN KEY (nome_museo)   REFERENCES MUSEO(nome),
    FOREIGN KEY (nome_artista) REFERENCES ARTISTA(nome)
);

CREATE TABLE PERSONAGGIO (
    id               INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome_personaggio VARCHAR(100) NOT NULL,
    codice_opera     INT          NOT NULL,
    FOREIGN KEY (codice_opera) REFERENCES OPERA(codice)
);

CREATE TABLE DIPINTO (
    codice        INT          NOT NULL PRIMARY KEY,
    tipo_pittura  VARCHAR(50)  NOT NULL,
    larghezza_cm  DECIMAL(7,2),
    altezza_cm    DECIMAL(7,2),
    FOREIGN KEY (codice) REFERENCES OPERA(codice) ON DELETE CASCADE
);

CREATE TABLE SCULTURA (
    codice      INT          NOT NULL PRIMARY KEY,
    materiale   VARCHAR(80)  NOT NULL,
    altezza_cm  DECIMAL(7,2),
    peso_kg     DECIMAL(7,2),
    FOREIGN KEY (codice) REFERENCES OPERA(codice) ON DELETE CASCADE
);

INSERT INTO MUSEO VALUES
('Uffizi',             'Firenze', 'Piazzale degli Uffizi 6',    'Eike Schmidt'),
('Louvre',             'Parigi',  'Rue de Rivoli 75001',        'Laurence des Cars'),
('Museo del Prado',    'Madrid',  'Calle de Ruiz de Alarcón 23','Miguel Falomir');

INSERT INTO ARTISTA VALUES
('Leonardo da Vinci', 'Italiana',  '1452-04-15', '1519-05-02'),
('Michelangelo',      'Italiana',  '1475-03-06', '1564-02-18'),
('Francisco Goya',    'Spagnola',  '1746-03-30', '1828-04-16');

INSERT INTO OPERA (titolo, anno_creazione, nome_museo, nome_artista) VALUES
('La nascita di Venere',    1485, 'Uffizi',          'Leonardo da Vinci'),
('Gioconda',                1503, 'Louvre',           'Leonardo da Vinci'),
('Il giudizio universale',  1541, 'Uffizi',           'Michelangelo'),
('Saturno che divora i figli', 1823, 'Museo del Prado', 'Francisco Goya');

INSERT INTO PERSONAGGIO (nome_personaggio, codice_opera) VALUES
('Venere', 1), ('Monna Lisa', 2), ('Saturno', 4);

INSERT INTO DIPINTO VALUES
(1, 'Tempera su tavola', 172.5, 278.9),
(2, 'Olio su tavola',     53.0,  77.0),
(4, 'Olio su intonaco',  146.0,  83.0);

INSERT INTO SCULTURA VALUES
(3, 'Affresco', NULL, NULL);