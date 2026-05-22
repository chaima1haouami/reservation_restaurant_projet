USE restaurant_db;

-- Ajouter la colonne categorie dans la table plats
ALTER TABLE plats
ADD categorie VARCHAR(100) NOT NULL DEFAULT 'Plat principal';

-- Mettre à jour les catégories selon le nom du plat
UPDATE plats SET categorie = 'Pizza' WHERE nom LIKE 'Pizza%';
UPDATE plats SET categorie = 'Burger' WHERE nom LIKE 'Burger%';
UPDATE plats SET categorie = 'Pâtes' WHERE nom LIKE 'Pasta%';
UPDATE plats SET categorie = 'Mexicain' WHERE nom LIKE 'Tacos%';
UPDATE plats SET categorie = 'Viande' WHERE nom LIKE 'Escalope%';
UPDATE plats SET categorie = 'Traditionnel' WHERE nom LIKE 'Couscous%';
UPDATE plats SET categorie = 'Entrée' WHERE nom LIKE 'Brik%';
UPDATE plats SET categorie = 'Gratin' WHERE nom LIKE 'Lasagne%';
UPDATE plats SET categorie = 'Sandwich' WHERE nom LIKE 'Sandwich%';
UPDATE plats SET categorie = 'Salade' WHERE nom LIKE 'Salade%';