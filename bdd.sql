-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour filmopedia
CREATE DATABASE IF NOT EXISTS `filmopedia` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `filmopedia`;

-- Listage de la structure de table filmopedia. acteur
CREATE TABLE IF NOT EXISTS `acteur` (
  `id_acteur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  `picture` text,
  PRIMARY KEY (`id_acteur`),
  KEY `id_personne` (`id_personne`) USING BTREE,
  CONSTRAINT `acteur_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table filmopedia.acteur : ~22 rows (environ)
INSERT INTO `acteur` (`id_acteur`, `id_personne`, `picture`) VALUES
	(2, 2, 'public/img/Tobey_Maguire.webp'),
	(3, 4, 'public\\img\\2788235.jpg'),
	(4, 3, 'public\\img\\Kirsten_Dunst_Cannes_2016.jpg'),
	(5, 5, 'public\\img\\Topher_Grace.webp'),
	(6, 7, 'public\\img\\Cillian_Murphy-2014.jpg'),
	(7, 9, 'public\\img\\Florence_Pugh_-_The_Wonder_BFI_London_Film_Festival_Premiere,_October_2022_(cropped).jpg'),
	(9, 11, 'public\\img\\SYDNEY,_AUSTRALIA_-_JANUARY_23_Margot_Robbie_arrives_at_the_Australian_Premiere_of_\'I,_Tonya\'_on_January_23,_2018_in_Sydney,_Australia_(28074883999)_(cropped).jpg'),
	(10, 12, 'public\\img\\5-choses-a-savoir-sur-ryan-gosling.jpeg'),
	(11, 14, 'public\\img\\1200px-Rosanna_Arquette_-_Monte-Carlo_Television_Festival.jpg'),
	(12, 15, 'public\\img\\5510555.webp'),
	(13, 16, 'public\\img\\Courteney-Cox-ses-tendres-confidences-sur-sa-fille-Coco.jpg'),
	(14, 18, 'public\\img\\232032.jpg'),
	(15, 19, 'public\\img\\429761.webp'),
	(16, 20, 'public\\img\\Josh_Brolin_Berlin_2016.jpg'),
	(17, 22, 'public\\img\\648c115d2dbc696c.jpg'),
	(18, 24, 'public\\img\\Marie-Anne_Chazel_-_Monte-Carlo_Television_Festival.JPG'),
	(19, 25, 'public\\img\\190567.jpg'),
	(20, 26, 'public\\img\\507426.webp'),
	(22, 29, 'public\\img\\0172364.webp'),
	(23, 30, 'public\\img\\Jamie_Chung_2013.jpg'),
	(24, 32, 'public/img/No_image_available.svg.png'),
	(25, 33, 'public\\img\\Guillermo_del_Toro_2023.jpg');

-- Listage de la structure de table filmopedia. casting
CREATE TABLE IF NOT EXISTS `casting` (
  `id_film` int NOT NULL,
  `id_acteur` int NOT NULL,
  `id_role` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_acteur`,`id_role`),
  KEY `id_acteur` (`id_acteur`),
  KEY `id_role` (`id_role`),
  CONSTRAINT `casting_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `casting_ibfk_2` FOREIGN KEY (`id_acteur`) REFERENCES `acteur` (`id_acteur`),
  CONSTRAINT `casting_ibfk_3` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table filmopedia.casting : ~19 rows (environ)
INSERT INTO `casting` (`id_film`, `id_acteur`, `id_role`) VALUES
	(1, 3, 3),
	(2, 3, 3),
	(1, 4, 2),
	(2, 5, 4),
	(3, 6, 5),
	(3, 7, 6),
	(4, 9, 8),
	(4, 10, 9),
	(5, 12, 10),
	(5, 13, 11),
	(6, 15, 14),
	(6, 16, 15),
	(7, 17, 16),
	(8, 18, 17),
	(8, 19, 18),
	(8, 20, 19),
	(9, 22, 21),
	(9, 23, 22),
	(10, 24, 23);

-- Listage de la structure de table filmopedia. film
CREATE TABLE IF NOT EXISTS `film` (
  `id_film` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) DEFAULT NULL,
  `annee_sortie_fr` date DEFAULT NULL,
  `duree` int DEFAULT NULL,
  `synopsis` text,
  `note` varchar(50) DEFAULT NULL,
  `id_realisateur` int NOT NULL,
  `picture` text,
  PRIMARY KEY (`id_film`),
  KEY `id_realisateur` (`id_realisateur`),
  CONSTRAINT `film_ibfk_1` FOREIGN KEY (`id_realisateur`) REFERENCES `realisateur` (`id_realisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table filmopedia.film : ~12 rows (environ)
INSERT INTO `film` (`id_film`, `titre`, `annee_sortie_fr`, `duree`, `synopsis`, `note`, `id_realisateur`, `picture`) VALUES
	(1, 'Spider-Man 2', '2004-07-14', 127, 'Ecartelé entre son identité secrète de Spider-Man et sa vie d''étudiant, Peter Parker n''a pas réussi à garder celle qu''il aime, Mary Jane, qui est aujourd''hui comédienne et fréquente quelqu''un d''autre. Guidé par son seul sens du devoir, Peter vit désormais chacun de ses pouvoirs à la fois comme un don et comme une malédiction.', '4', 1, 'public\\img\\18380826.jpg'),
	(2, 'Spider-Man 3', '2007-05-01', 139, 'Peter Parker a enfin réussi à concilier son amour pour Mary-Jane et ses devoirs de super-héros, mais l''horizon s''obscurcit. La brutale mutation de son costume, qui devient noir, décuple ses pouvoirs et transforme également sa personnalité pour laisser ressortir l''aspect sombre et vengeur que Peter s''efforce de contrôler.', '4.5', 1, 'public\\img\\18754165.jpg'),
	(3, 'Oppenheimer', '2023-07-19', 180, 'Biopic sur Julius Robert Oppenheimer, brillant chercheur épris de culture et d''humanisme, connu pour avoir dirigé, aux États-Unis, la mise au point de la bombe atomique pendant la Seconde Guerre mondiale.', '4.5', 2, 'public\\img\\2793170.webp'),
	(4, 'Barbie Movie', '2023-07-19', 114, 'Barbie, qui vit à Barbie Land, est expulsée du pays pour être loin d''être une poupée à l''apparence parfaite; n''ayant nulle part où aller, elle part pour le monde humain et cherche le vrai bonheur.', '2.5', 3, 'public\\img\\4590179.webp'),
	(5, 'Scream', '1997-07-16', 111, 'Casey Becker, une belle adolescente, est seule dans la maison familiale. Elle s''apprête à regarder un film d''horreur, mais le téléphone sonne. Au bout du fil, un tueur en série la malmène, et la force à jouer à un jeu terrible: si elle répond mal à ses questions portant sur les films d''horreur, celui-ci tuera son copain. Sidney Prescott sait qu''elle est l''une des victimes potentielles du tueur de Woodsboro. Celle-ci ne sait plus à qui faire confiance.', '3', 4, 'public\\img\\5601453.jpg'),
	(6, 'No Country for Old Men', '2008-01-23', 122, 'A la frontière qui sépare le Texas du Mexique, les trafiquants de drogue ont depuis longtemps remplacé les voleurs de bétail. Lorsque Llewelyn Moss tombe sur une camionnette abandonnée, cernée de cadavres, il ne sait rien de ce qui a conduit à ce drame. Quand il prend les deux millions de dollars qu''il découvre à l''intérieur du véhicule, il n''a pas la moindre idée de ce que cela va provoquer. Moss a déclenché une réaction en chaîne d''une violence inouïe.', '4', 5, 'public\\img\\21053452_20131028155459275.webp'),
	(7, 'Shiny_Flakes : Le petit baron du darknet', '2021-08-03', 97, 'Tirant parti de son propre site, shinyflakes.com, et de la poste allemande, le jeune garçon de 19 ans a bâti et dirigé un empire de la drogue international à lui tout seul, parvenant à vendre une tonne de substances illicites en l''espace de 14 mois.', '3.5', 6, 'public\\img\\3843496.jpg'),
	(8, 'Les Bronzés 3', '2006-02-01', 97, 'Depuis quelques années, ils se retrouvent chaque été, pour une semaine, au Prunus Resort, hôtel de luxe et de bord de mer, dont Popeye s''occupe plus ou moins bien en tant que gérant, et qui appartient à sa femme, Graziella Lespinasse, héritière d''une des plus grosses fortunes italiennes. Que sont devenus les Bronzés 27 ans après ? Réponse hâtive : les mêmes, en pire.', '1.5', 7, 'public\\img\\18467807.jpg'),
	(9, 'Dragon ball Evolution', '2009-04-10', 100, 'Sangoku, un jeune lycéen doit répondre à la dernière volonté de son grand-père : rechercher maître Roshi, un expert en arts martiaux. Ce dernier lui donne la mission de retrouver les sept boules de cristal, les Dragon Balls, avant qu''un puissant démon, Lord Piccolo, ne parvienne à les réunir pour dominer le monde en utilisant leurs pouvoirs.', '1', 8, 'public\\img\\19065645.jpg'),
	(10, 'Las Vegas Parano', '1998-08-19', 118, 'À travers l''épopée à la fois comique et horrible vers Las Vegas du journaliste Raoul Duke et de son énorme avocat, le Dr. Gonzo, évocation caustique et brillante de l''année 1971 aux États-Unis, pendant laquelle les espoirs des années 60 et le fameux rêve américain furent balayés pour laisser la place à un cynisme plus politiquement correct.', '3.5', 9, 'public\\img\\172720.jpg'),
	(11, 'Héritage', '2012-12-12', 88, 'Une famille palestinienne se rassemble dans le nord de la Galilée pour célébrer un mariage, dans un climat de guerre. Lorsque le patriarche tombe dans le coma, les conflits internes font exploser peu à peu l’harmonie familiale, révélant secrets et mensonges jusqu’alors enfouis.', '3', 10, 'public\\img\\20288718.jpg'),
	(33, 'test', '0001-01-01', 1, '1', '', 3, 'public/img/363658.jpg');

-- Listage de la structure de table filmopedia. genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) DEFAULT NULL,
  `picture` text,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table filmopedia.genre : ~10 rows (environ)
INSERT INTO `genre` (`id_genre`, `libelle`, `picture`) VALUES
	(1, 'Action Super-Hero', 'public\\img\\super-heros-03-1000x750.jpg'),
	(2, 'Guerre Histoire', 'public\\img\\4402672.jpg'),
	(3, 'Comedie Film pour enfants', 'public\\img\\phalbm26106368.jpg'),
	(4, 'Horreur Slasher', 'public\\img\\DIyc_X3UEAAlQJy-945x611.jpg'),
	(5, 'Western Thriller', 'public\\img\\37549331.webp'),
	(6, 'Documentaire', 'public\\img\\CineDocumentaire-972x1400.jpg'),
	(7, 'Comedie', 'public\\img\\cover.jpg'),
	(8, 'Anime Action', 'public\\img\\promare-bis-2.jpg'),
	(9, 'Comedie Aventure', 'public\\img\\363658.jpg'),
	(10, 'Drame', 'public\\img\\Les-femmes-pleurent-plus-que-les-hommes-et-deux-fois-plus-longtemps.webp');

-- Listage de la structure de table filmopedia. genre_film
CREATE TABLE IF NOT EXISTS `genre_film` (
  `id_film` int NOT NULL,
  `id_genre` int NOT NULL,
  PRIMARY KEY (`id_film`,`id_genre`),
  KEY `id_genre` (`id_genre`),
  CONSTRAINT `genre_film_ibfk_1` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `genre_film_ibfk_2` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table filmopedia.genre_film : ~12 rows (environ)
INSERT INTO `genre_film` (`id_film`, `id_genre`) VALUES
	(1, 1),
	(2, 1),
	(3, 2),
	(4, 3),
	(5, 4),
	(6, 5),
	(7, 6),
	(8, 7),
	(33, 7),
	(9, 8),
	(10, 9),
	(11, 10);

-- Listage de la structure de table filmopedia. personne
CREATE TABLE IF NOT EXISTS `personne` (
  `id_personne` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `sexe` varchar(30) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  PRIMARY KEY (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table filmopedia.personne : ~35 rows (environ)
INSERT INTO `personne` (`id_personne`, `nom`, `prenom`, `sexe`, `date_naissance`) VALUES
	(1, 'Raimi', 'Sam', 'homme', '1959-10-23'),
	(2, 'Maguire', 'Tobey', 'homme', '1975-06-27'),
	(3, 'Dunst ', 'Kirsten', 'femme', '1982-04-30'),
	(4, 'Dafoe', 'William James', 'homme', '1955-07-22'),
	(5, '-ruy-r', 'tyryr', 'tyry', '0111-11-11'),
	(6, 'Nolan', 'Christopher', 'homme', '1970-07-30'),
	(7, 'Murphy', 'Cillian', 'homme', '1976-05-27'),
	(8, 'ddddd', 'ddddd', 'dd', '1111-11-11'),
	(9, 'Pugh', 'Florence', 'femme', '1996-01-03'),
	(10, 'Gerwig', 'Greta', 'femme', '1983-08-04'),
	(11, 'Robbie', 'Margot', 'femme', '1990-07-02'),
	(12, 'Gosling', 'Ryan', 'homme', '1980-11-12'),
	(13, 'Craven', 'Wesley Earl', 'homme', '1939-08-02'),
	(14, 'erzer', 'ezrzer', 'erzrz', '0023-01-14'),
	(15, 'Campbell', 'Neve', 'femme', '1973-10-03'),
	(16, 'Cox', 'Courteney', 'femme', '1964-06-15'),
	(17, 'Coen', 'Joel', 'homme', '1954-11-29'),
	(18, 'rdg', 'rtrdt', 'retr', '1111-11-11'),
	(19, 'Jones', 'Tommy Lee', 'homme', '1946-09-15'),
	(20, 'Brolin', 'Josh', 'homme', '1968-02-12'),
	(21, 'Müller', 'Eva', 'femme', '1981-01-01'),
	(22, 'Schmidt', 'Maximilian', 'homme', '1999-09-23'),
	(23, 'Leconte', 'Patrice', 'homme', '1947-11-12'),
	(24, 'Chazel', 'Marie-Anne', 'femme', '1951-09-19'),
	(25, ' Lhermitte', 'Thierry', 'homme', '1952-11-24'),
	(26, 'Blanc', 'Michel', 'homme', '1952-04-16'),
	(27, 'Wong', 'James', 'homme', '1959-04-20'),
	(28, 'prout', 'prout', 'Homme', '2216-01-14'),
	(29, 'Rossum', 'Emmy', 'femme', '1986-09-12'),
	(30, 'Chung', 'Jamie', 'femme', '1983-04-10'),
	(31, 'Gilliam', 'Terry', 'homme', '1940-11-22'),
	(32, 'Personne Supprimer', NULL, 'Personne Supprimer', '0001-01-01'),
	(33, 'del Toro', 'Benicio', 'homme', '1967-02-19'),
	(34, 'Personne Supprimer', NULL, 'Personne Supprimer', '0001-01-01'),
	(126, 'Christian', 'Bale', 'Homme', '1974-01-30');

-- Listage de la structure de table filmopedia. realisateur
CREATE TABLE IF NOT EXISTS `realisateur` (
  `id_realisateur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  `picture` text,
  PRIMARY KEY (`id_realisateur`),
  KEY `id_personne` (`id_personne`) USING BTREE,
  CONSTRAINT `realisateur_ibfk_1` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table filmopedia.realisateur : ~10 rows (environ)
INSERT INTO `realisateur` (`id_realisateur`, `id_personne`, `picture`) VALUES
	(1, 1, 'public\\img\\20480744.jpg'),
	(2, 6, 'public\\img\\Christopher_Nolan_Cannes_2018.jpg'),
	(3, 10, 'public\\img\\0537904.webp'),
	(4, 13, 'public\\img\\594604.jpg'),
	(5, 17, 'public\\img\\499517.webp'),
	(6, 21, 'public\\img\\Hanns_joachim_friedrichs_preis_2013_7.jpg'),
	(7, 23, 'public\\img\\451187.webp'),
	(8, 27, 'public\\img\\467556.jpg'),
	(9, 31, 'public\\img\\image-w856.webp'),
	(10, 34, 'public/img/No_image_available.svg.png');

-- Listage de la structure de table filmopedia. role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table filmopedia.role : ~26 rows (environ)
INSERT INTO `role` (`id_role`, `libelle`) VALUES
	(1, 'Spiderman'),
	(2, 'Marie-Jane'),
	(3, 'Bouffon Vert'),
	(4, 'Venom'),
	(5, 'Robert Oppenheimer'),
	(6, 'Katherine Oppenheimer'),
	(7, 'Jean Tatlock'),
	(8, 'Barbie'),
	(9, 'Ken'),
	(10, 'Sidney Prescott'),
	(11, 'Gale Weathers-Riley'),
	(12, 'Dwight Riley'),
	(13, 'Anton Chigurh'),
	(14, 'Ed Tom Bell'),
	(15, 'Llewelyn Moss'),
	(16, 'Maximilian Schmidt'),
	(17, 'Gigi'),
	(18, 'Popeye'),
	(19, 'Jean-Claude'),
	(20, 'Son Goku'),
	(21, 'Bulma'),
	(22, 'Chichi'),
	(23, 'Raoul Duke'),
	(24, 'Dr Gonzo'),
	(25, 'Hitchhiker'),
	(26, 'HIAM ABBASS');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
