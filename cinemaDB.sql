CREATE DATABASE IF NOT EXISTS Cinema;
USE Cinema;

CREATE TABLE FILM (
    CodFilm         INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Titolo          VARCHAR(100) NOT NULL,
    AnnoProduzione  YEAR         NOT NULL,
    Nazionalita     VARCHAR(50)  NOT NULL,
    Regista         VARCHAR(80)  NOT NULL,
    Genere          VARCHAR(40)  NOT NULL,
    Durata          INT          NOT NULL  -- minuti
);

INSERT INTO FILM (Titolo, AnnoProduzione, Nazionalita, Regista, Genere, Durata) VALUES
('8½',                          1963, 'Italiana',   'F. Fellini',      'Drammatico',    138),
('La dolce vita',               1960, 'Italiana',   'F. Fellini',      'Drammatico',    174),
('Amarcord',                    1973, 'Italiana',   'F. Fellini',      'Commedia',      127),
('Casablanca',                  1942, 'Americana',  'M. Curtiz',       'Drammatico',    102),
('Mildred Pierce',              1945, 'Americana',  'M. Curtiz',       'Noir',          111),
('Godzilla',                    1954, 'Giapponese', 'I. Honda',        'Fantascienza',   96),
('Akira',                       1988, 'Giapponese', 'K. Otomo',        'Fantascienza',  124),
('Ghost in the Shell',          1995, 'Giapponese', 'M. Oshii',        'Fantascienza',   83),
('Neon Genesis Evangelion 1.0', 2007, 'Giapponese', 'H. Anno',         'Fantascienza',   98),
('La Jetée',                    1962, 'Francese',   'C. Marker',       'Fantascienza',   28),
('Alphaville',                  1965, 'Francese',   'J-L. Godard',     'Fantascienza',   99),
('La città incantata',          2001, 'Giapponese', 'H. Miyazaki',     'Animazione',    125),
('Il mio vicino Totoro',        1988, 'Giapponese', 'H. Miyazaki',     'Animazione',     86),
('Metropolis',                  1927, 'Tedesca',    'F. Lang',         'Fantascienza',  153),
('Blade Runner',                1982, 'Americana',  'R. Scott',        'Fantascienza',  117),
('Matrix',                      1999, 'Americana',  'L. Wachowski',    'Fantascienza',  136),
('Il gladiatore',               2000, 'Americana',  'R. Scott',        'Azione',        155),
('Alien',                       1979, 'Americana',  'R. Scott',        'Fantascienza',  117),
('I predatori dell\'arca perduta', 1981, 'Americana', 'S. Spielberg',  'Azione',        115),
('Die Hard',                    1988, 'Americana',  'J. McTiernan',    'Azione',        132),
('Terminator 2',                1991, 'Americana',  'J. Cameron',      'Azione',        137),
('La finestra sul cortile',     1954, 'Americana',  'A. Hitchcock',    'Thriller',      112),
('Il cavaliere oscuro',         2008, 'Americana',  'C. Nolan',        'Azione',        152),
('Roma',                        1972, 'Italiana',   'F. Fellini',      'Documentario',  128),
('Godzilla vs Kong',            2021, 'Americana',  'A. Wingard',      'Azione',        113),
('Prometeo',                    1998, 'Italiana',   'M. Bellocchio',   'Drammatico',     97),
('La métropole enchantée',      2003, 'Francese',   'J. Rivette',      'Drammatico',    197),
('Resident Evil',               2002, 'Americana',  'P.W.S. Anderson', 'Azione',        100);

SELECT Titolo
FROM FILM
WHERE Regista = 'F. Fellini'
  AND AnnoProduzione > 1960;

SELECT Titolo, Durata
FROM FILM
WHERE Genere = 'Fantascienza'
  AND AnnoProduzione > 1990
  AND (Nazionalita = 'Giapponese' OR Nazionalita = 'Francese');

SELECT Titolo
FROM FILM
WHERE (Genere = 'Fantascienza' AND Nazionalita = 'Giapponese' AND AnnoProduzione > 1990)
   OR (Genere = 'Fantascienza' AND Nazionalita = 'Francese');

SELECT Titolo
FROM FILM
WHERE Regista = (
    SELECT Regista FROM FILM WHERE Titolo = 'Casablanca'
)
  AND Titolo <> 'Casablanca';

SELECT *
FROM FILM
WHERE Regista = 'F. Fellini'
ORDER BY Titolo ASC;

SELECT COUNT(*) AS NumFilmAzione
FROM FILM
WHERE Genere = 'Azione';

SELECT *
FROM FILM
WHERE Nazionalita = 'Italiana'
  AND Genere IN ('Fantascienza', 'Azione')
  AND AnnoProduzione < 2010;

SELECT DISTINCT Regista
FROM FILM
WHERE Nazionalita = 'Francese'
  AND Genere = 'Fantascienza'
ORDER BY Regista ASC;

SELECT COUNT(*) AS NumFilmGiapponesi70_80
FROM FILM
WHERE Nazionalita = 'Giapponese'
  AND AnnoProduzione BETWEEN 1970 AND 1980;