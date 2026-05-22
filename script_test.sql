-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.4.3 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour restaurant_db
CREATE DATABASE IF NOT EXISTS `restaurant_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `restaurant_db`;

-- Listage de la structure de table restaurant_db. commandes
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `plat_id` int NOT NULL,
  `quantite` int DEFAULT '1',
  `total` decimal(10,2) NOT NULL,
  `statut` varchar(50) DEFAULT 'panier',
  `date_commande` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `plat_id` (`plat_id`),
  CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `commandes_ibfk_2` FOREIGN KEY (`plat_id`) REFERENCES `plats` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table restaurant_db.commandes : ~21 rows (environ)
INSERT INTO `commandes` (`id`, `user_id`, `plat_id`, `quantite`, `total`, `statut`, `date_commande`) VALUES
	(2, 2, 94, 1, 14.00, 'payée', '2026-05-16 15:55:06'),
	(3, 2, 94, 1, 14.00, 'payée', '2026-05-16 15:56:46'),
	(4, 2, 97, 1, 17.00, 'payée', '2026-05-16 15:57:29'),
	(5, 2, 97, 1, 17.00, 'payée', '2026-05-16 15:57:42'),
	(6, 2, 95, 1, 15.00, 'payée', '2026-05-16 15:58:16'),
	(7, 2, 94, 1, 14.00, 'payée', '2026-05-16 16:35:48'),
	(8, 3, 94, 1, 14.00, 'panier', '2026-05-16 16:47:27'),
	(9, 3, 95, 1, 15.00, 'panier', '2026-05-16 17:40:15'),
	(10, 2, 98, 1, 38.00, 'payée', '2026-05-16 20:33:44'),
	(17, 2, 95, 1, 15.00, 'payée', '2026-05-17 02:41:18'),
	(18, 2, 95, 1, 15.00, 'payée', '2026-05-17 02:47:24'),
	(19, 2, 92, 1, 12.00, 'payée', '2026-05-17 02:47:43'),
	(20, 2, 74, 1, 24.00, 'payée', '2026-05-17 02:51:19'),
	(21, 2, 95, 7, 105.00, 'payée', '2026-05-17 02:54:34'),
	(22, 2, 98, 1, 38.00, 'payée', '2026-05-17 02:59:08'),
	(23, 2, 80, 1, 30.00, 'payée', '2026-05-17 03:01:00'),
	(24, 2, 95, 1, 15.00, 'payée', '2026-05-17 03:05:51'),
	(25, 2, 95, 2, 30.00, 'payée', '2026-05-17 03:15:20'),
	(27, 2, 98, 1, 38.00, 'payée', '2026-05-17 12:40:08'),
	(28, 2, 95, 1, 15.00, 'payée', '2026-05-17 12:46:55'),
	(29, 2, 98, 1, 38.00, 'panier', '2026-05-17 14:12:55');

-- Listage de la structure de table restaurant_db. plats
CREATE TABLE IF NOT EXISTS `plats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prix` float DEFAULT NULL,
  `categorie` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table restaurant_db.plats : ~100 rows (environ)
INSERT INTO `plats` (`id`, `nom`, `prix`, `categorie`, `description`, `image`) VALUES
	(1, 'Pizza Margherita 1', 11, 'Pizza', NULL, NULL),
	(2, 'Burger Classic 2', 12, 'Burger', NULL, NULL),
	(3, 'Pasta Alfredo 3', 13, 'Pâtes', NULL, NULL),
	(4, 'Tacos 4', 14, 'Mexicain', NULL, NULL),
	(5, 'Escalope 5', 15, 'Viande', NULL, NULL),
	(6, 'Couscous 6', 16, 'Traditionnel', NULL, NULL),
	(7, 'Brik 7', 17, 'Entrée', NULL, NULL),
	(8, 'Lasagne 8', 18, 'Gratin', NULL, NULL),
	(9, 'Sandwich Club 9', 19, 'Sandwich', NULL, NULL),
	(10, 'Salade César 10', 20, 'Salade', NULL, NULL),
	(11, 'Pizza Margherita 11', 21, 'Pizza', NULL, NULL),
	(12, 'Burger Classic 12', 22, 'Burger', NULL, NULL),
	(13, 'Pasta Alfredo 13', 23, 'Pâtes', NULL, NULL),
	(14, 'Tacos 14', 24, 'Mexicain', NULL, NULL),
	(15, 'Escalope 15', 25, 'Viande', NULL, NULL),
	(16, 'Couscous 16', 26, 'Traditionnel', NULL, NULL),
	(17, 'Brik 17', 27, 'Entrée', NULL, NULL),
	(18, 'Lasagne 18', 28, 'Gratin', NULL, NULL),
	(19, 'Sandwich Club 19', 29, 'Sandwich', NULL, NULL),
	(20, 'Salade César 20', 10, 'Salade', NULL, NULL),
	(21, 'Pizza Margherita 21', 31, 'Pizza', NULL, NULL),
	(22, 'Burger Classic 22', 32, 'Burger', NULL, NULL),
	(23, 'Pasta Alfredo 23', 33, 'Pâtes', NULL, NULL),
	(24, 'Tacos 24', 34, 'Mexicain', NULL, NULL),
	(25, 'Escalope 25', 35, 'Viande', NULL, NULL),
	(26, 'Couscous 26', 36, 'Traditionnel', NULL, NULL),
	(27, 'Brik 27', 37, 'Entrée', NULL, NULL),
	(28, 'Lasagne 28', 38, 'Gratin', NULL, NULL),
	(29, 'Sandwich Club 29', 39, 'Sandwich', NULL, NULL),
	(30, 'Salade César 30', 10, 'Salade', NULL, NULL),
	(31, 'Pizza Margherita 31', 11, 'Pizza', NULL, NULL),
	(32, 'Burger Classic 32', 12, 'Burger', NULL, NULL),
	(33, 'Pasta Alfredo 33', 13, 'Pâtes', NULL, NULL),
	(34, 'Tacos 34', 14, 'Mexicain', NULL, NULL),
	(35, 'Escalope 35', 15, 'Viande', NULL, NULL),
	(36, 'Couscous 36', 16, 'Traditionnel', NULL, NULL),
	(37, 'Brik 37', 17, 'Entrée', NULL, NULL),
	(38, 'Lasagne 38', 18, 'Gratin', NULL, NULL),
	(39, 'Sandwich Club 39', 19, 'Sandwich', NULL, NULL),
	(40, 'Salade César 40', 20, 'Salade', NULL, NULL),
	(41, 'Pizza Margherita 41', 21, 'Pizza', NULL, NULL),
	(42, 'Burger Classic 42', 22, 'Burger', NULL, NULL),
	(43, 'Pasta Alfredo 43', 23, 'Pâtes', NULL, NULL),
	(44, 'Tacos 44', 24, 'Mexicain', NULL, NULL),
	(45, 'Escalope 45', 25, 'Viande', NULL, NULL),
	(46, 'Couscous 46', 26, 'Traditionnel', NULL, NULL),
	(47, 'Brik 47', 27, 'Entrée', NULL, NULL),
	(48, 'Lasagne 48', 28, 'Gratin', NULL, NULL),
	(49, 'Sandwich Club 49', 29, 'Sandwich', NULL, NULL),
	(50, 'Salade César 50', 30, 'Salade', NULL, NULL),
	(51, 'Pizza Margherita 51', 31, 'Pizza', NULL, NULL),
	(52, 'Burger Classic 52', 32, 'Burger', NULL, NULL),
	(53, 'Pasta Alfredo 53', 33, 'Pâtes', NULL, NULL),
	(54, 'Tacos 54', 34, 'Mexicain', NULL, NULL),
	(55, 'Escalope 55', 35, 'Viande', NULL, NULL),
	(56, 'Couscous 56', 36, 'Traditionnel', NULL, NULL),
	(57, 'Brik 57', 37, 'Entrée', NULL, NULL),
	(58, 'Lasagne 58', 38, 'Gratin', NULL, NULL),
	(59, 'Sandwich Club 59', 39, 'Sandwich', NULL, NULL),
	(60, 'Salade César 60', 10, 'Salade', NULL, NULL),
	(61, 'Pizza Margherita 61', 11, 'Pizza', NULL, NULL),
	(62, 'Burger Classic 62', 12, 'Burger', NULL, NULL),
	(63, 'Pasta Alfredo 63', 13, 'Pâtes', NULL, NULL),
	(64, 'Tacos 64', 14, 'Mexicain', NULL, NULL),
	(65, 'Escalope 65', 15, 'Viande', NULL, NULL),
	(66, 'Couscous 66', 16, 'Traditionnel', NULL, NULL),
	(67, 'Brik 67', 17, 'Entrée', NULL, NULL),
	(68, 'Lasagne 68', 18, 'Gratin', NULL, NULL),
	(69, 'Sandwich Club 69', 19, 'Sandwich', NULL, NULL),
	(70, 'Salade César 70', 20, 'Salade', NULL, NULL),
	(71, 'Pizza Margherita 71', 21, 'Pizza', NULL, NULL),
	(72, 'Burger Classic 72', 22, 'Burger', NULL, NULL),
	(73, 'Pasta Alfredo 73', 23, 'Pâtes', NULL, NULL),
	(74, 'Tacos 74', 24, 'Mexicain', NULL, NULL),
	(75, 'Escalope 75', 25, 'Viande', NULL, NULL),
	(76, 'Couscous 76', 26, 'Traditionnel', NULL, NULL),
	(77, 'Brik 77', 27, 'Entrée', NULL, NULL),
	(78, 'Lasagne 78', 28, 'Gratin', NULL, NULL),
	(79, 'Sandwich Club 79', 29, 'Sandwich', NULL, NULL),
	(80, 'Salade César 80', 30, 'Salade', NULL, NULL),
	(81, 'Pizza Margherita 81', 31, 'Pizza', NULL, NULL),
	(82, 'Burger Classic 82', 32, 'Burger', NULL, NULL),
	(83, 'Pasta Alfredo 83', 33, 'Pâtes', NULL, NULL),
	(84, 'Tacos 84', 34, 'Mexicain', NULL, NULL),
	(85, 'Escalope 85', 35, 'Viande', NULL, NULL),
	(86, 'Couscous 86', 36, 'Traditionnel', NULL, NULL),
	(87, 'Brik 87', 37, 'Entrée', NULL, NULL),
	(88, 'Lasagne 88', 38, 'Gratin', NULL, NULL),
	(89, 'Sandwich Club 89', 39, 'Sandwich', NULL, NULL),
	(90, 'Salade César 90', 10, 'Salade', NULL, NULL),
	(91, 'Pizza Margherita 91', 11, 'Pizza', NULL, NULL),
	(92, 'Burger Classic 92', 12, 'Burger', NULL, NULL),
	(93, 'Pasta Alfredo 93', 13, 'Pâtes', NULL, NULL),
	(94, 'Tacos 94', 14, 'Mexicain', NULL, NULL),
	(95, 'Escalope 95', 15, 'Viande', NULL, NULL),
	(96, 'Couscous 96', 16, 'Traditionnel', NULL, NULL),
	(97, 'Brik 97', 17, 'Entrée', NULL, NULL),
	(98, 'Lasagne 98', 38, 'Gratin', NULL, NULL),
	(99, 'Sandwich Club 99', 39, 'Sandwich', NULL, NULL),
	(102, 'Couscous poulpe', 60, 'Tunsisien', '', NULL);

-- Listage de la structure de table restaurant_db. reservations
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `user_id` int DEFAULT NULL,
  `date_reservation` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  `personnes` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table restaurant_db.reservations : ~53 rows (environ)
INSERT INTO `reservations` (`id`, `nom`, `user_id`, `date_reservation`, `heure`, `personnes`) VALUES
	(1, '', NULL, '2026-02-02', '13:30:00', 2),
	(2, '', NULL, '2026-03-03', '14:00:00', 3),
	(3, '', NULL, '2026-04-04', '15:30:00', 4),
	(4, '', NULL, '2026-05-05', '16:00:00', 5),
	(5, '', NULL, '2026-06-06', '17:30:00', 6),
	(6, '', NULL, '2026-07-07', '18:00:00', 1),
	(7, '', NULL, '2026-08-08', '19:30:00', 2),
	(8, '', NULL, '2026-09-09', '20:00:00', 3),
	(9, '', NULL, '2026-10-10', '21:30:00', 4),
	(10, '', NULL, '2026-11-11', '12:00:00', 5),
	(11, '', NULL, '2026-12-12', '13:30:00', 6),
	(12, '', NULL, '2026-01-13', '14:00:00', 1),
	(13, '', NULL, '2026-02-14', '15:30:00', 2),
	(14, '', NULL, '2026-03-15', '16:00:00', 3),
	(15, '', NULL, '2026-04-16', '17:30:00', 4),
	(16, '', NULL, '2026-05-17', '18:00:00', 5),
	(17, '', NULL, '2026-06-18', '19:30:00', 6),
	(18, '', NULL, '2026-07-19', '20:00:00', 1),
	(19, '', NULL, '2026-08-20', '21:30:00', 2),
	(20, '', NULL, '2026-09-21', '12:00:00', 3),
	(21, '', NULL, '2026-10-22', '13:30:00', 4),
	(22, '', NULL, '2026-11-23', '14:00:00', 5),
	(23, '', NULL, '2026-12-24', '15:30:00', 6),
	(24, '', NULL, '2026-01-25', '16:00:00', 1),
	(25, '', NULL, '2026-02-26', '17:30:00', 2),
	(26, '', NULL, '2026-03-27', '18:00:00', 3),
	(27, '', NULL, '2026-04-28', '19:30:00', 4),
	(28, '', NULL, '2026-05-01', '20:00:00', 5),
	(29, '', NULL, '2026-06-02', '21:30:00', 6),
	(30, '', NULL, '2026-07-03', '12:00:00', 1),
	(31, '', NULL, '2026-08-04', '13:30:00', 2),
	(32, '', NULL, '2026-09-05', '14:00:00', 3),
	(33, '', NULL, '2026-10-06', '15:30:00', 4),
	(34, '', NULL, '2026-11-07', '16:00:00', 5),
	(35, '', NULL, '2026-12-08', '17:30:00', 6),
	(36, '', NULL, '2026-01-09', '18:00:00', 1),
	(37, '', NULL, '2026-02-10', '19:30:00', 2),
	(38, '', NULL, '2026-03-11', '20:00:00', 3),
	(39, '', NULL, '2026-04-12', '21:30:00', 4),
	(40, '', NULL, '2026-05-13', '12:00:00', 5),
	(41, '', NULL, '2026-06-14', '13:30:00', 6),
	(42, '', NULL, '2026-07-15', '14:00:00', 1),
	(43, '', NULL, '2026-08-16', '15:30:00', 2),
	(44, '', NULL, '2026-09-17', '16:00:00', 3),
	(45, '', NULL, '2026-10-18', '17:30:00', 4),
	(46, '', NULL, '2026-11-19', '18:00:00', 5),
	(47, '', NULL, '2026-12-20', '19:30:00', 6),
	(48, '', NULL, '2026-01-21', '20:00:00', 1),
	(49, 'Haouami chaima', NULL, '2026-05-26', '20:00:00', 2),
	(50, 'israa dhahbi', NULL, '2026-06-20', '14:00:00', 4),
	(51, 'chaima haouami', NULL, '2026-07-17', '20:00:00', 2),
	(52, 'Nour massaoudi', NULL, '2026-05-25', '22:00:00', 4),
	(53, 'Youssef Rhouma', NULL, '2026-06-19', '13:00:00', 6);

-- Listage de la structure de table restaurant_db. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'client',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table restaurant_db.users : ~5 rows (environ)
INSERT INTO `users` (`id`, `nom`, `email`, `password`, `role`) VALUES
	(1, 'admin', 'admin@gmail.com', '$2y$10$UIeArH9QvYP11qwBxAg0nOseA9iQ9nih.ZXjypMoSVei..OlyAfpm', 'admin'),
	(2, 'Youssef Rhouma', 'Youssef_rhouma@gmail.com', '$2y$10$yNyKf5J4eWXfGkQIGRbS0OeixQfWJRd2I1negcYe.E6uZxB9jULv6', 'user'),
	(3, 'Haouami chaima', 'chaimahaouami@gmail.com', '$2y$10$4TqQD5Q/ydgcU039Dg4/LOHUSwMbbA5/oZuARq0g6J0hriC5VxglS', 'user'),
	(4, 'Nour massaoudi', 'Nour_massouadi@gmail.com', '$2y$10$rcpctVsI6IyfxPzXBt2PmuJYTFvrKNu7AY4Z8UXzGvDY4kbPh5oXC', 'user'),
	(5, 'israa dhahbi', 'dhahbi_israa@gmail.com', '$2y$10$5qZPmGIsaiBFnLjFPTYpBeuY8eznyM.iE7ZyiigFLKBDzV/WcjE6W', 'user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
