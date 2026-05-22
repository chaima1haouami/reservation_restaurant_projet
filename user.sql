USE restaurant_db;

SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE reservations;
TRUNCATE TABLE plats;
TRUNCATE TABLE users;

SET FOREIGN_KEY_CHECKS = 1;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(100)
);

CREATE TABLE plats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prix DECIMAL(10,2)
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_reservation DATE,
    heure TIME,
    personnes INT
);restaurant_db


