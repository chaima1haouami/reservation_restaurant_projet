restaurant_dbUPDATE plats SET categorie = 'Tunisien' WHERE LOWER(categorie) LIKE '%tunis%';
UPDATE plats SET categorie = 'Français' WHERE LOWER(categorie) LIKE '%franc%';
UPDATE plats SET categorie = 'Italien' WHERE LOWER(categorie) LIKE '%ital%';
UPDATE plats SET categorie = 'Fruits de mer' WHERE LOWER(categorie) LIKE '%fruit%';
UPDATE plats SET categorie = 'Pasta' WHERE LOWER(categorie) LIKE '%pasta%';
UPDATE plats SET categorie = 'Dessert' WHERE LOWER(categorie) LIKE '%dess%';