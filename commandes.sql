CREATE TABLE commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    plat_id INT NOT NULL,
    quantite INT DEFAULT 1,
    total DECIMAL(10,2) NOT NULL,
    statut VARCHAR(50) DEFAULT 'panier',
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (plat_id) REFERENCES plats(id) ON DELETE CASCADE
);