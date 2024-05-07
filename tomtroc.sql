-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 07 mai 2024 à 13:40
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tomtroc`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `available` tinyint(1) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `user_id`, `title`, `author`, `description`, `available`, `image`) VALUES
(3, 3, 'Titre de livre', 'Auteur numéro 1', 'Description Description du livre 3', 1, 'hamza-nouasria.jpg'),
(4, 3, 'Titre Livre 3', 'Auteur 3', 'Description du livre 3', 1, 'hamza-nouasria.jpg'),
(5, 3, 'Titre Livre 3', 'Auteur 3', 'Description du livre 3', 1, 'hamza-nouasria.jpg'),
(7, 6, 'Titre de livrez', 'Auteur numéro 1z', 'Description Description du livre 3z', 1, 'hamza-nouasria.jpg'),
(8, 6, 'Titre de livrezz', 'Auteur numéro 1zz', 'Description Description du livre 3\r\n', 1, 'hamza-nouasria.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `id_sender` int(11) NOT NULL,
  `id_receiver` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `message`, `date`, `id_sender`, `id_receiver`) VALUES
(4, 'Bonjour', '2024-04-21 17:30:32', 6, 7),
(5, 'Bonsoir, tu viens demain au restaurant? Bonjour2\nReceiver id 6', '2024-04-21 17:30:35', 7, 6),
(6, 'Oui', '2024-04-21 17:50:32', 6, 7),
(7, 'Bonjour', '2024-04-21 17:30:38', 3, 6),
(8, 'Bonjour', '2024-04-21 17:30:32', 1, 7);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `num_livre` int(10) DEFAULT NULL,
  `register_date` datetime DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `pseudo`, `num_livre`, `register_date`, `image`) VALUES
(1, 'utilisateur1@gmail.com', 'motdepasse1', 'pseudo1', 123, '2024-02-01 08:30:00', 'darwin-vegher.jpg'),
(2, 'utilisateur2@gmail.com', 'motdepasse2', 'pseudo2', 456, '2024-02-01 09:15:00', 'darwin-vegher.jpg'),
(3, 'utilisateur3@gmail.com', 'motdepasse3', 'Demo 3', 789, '2024-02-01 10:00:00', NULL),
(6, 'inscription@inscription.com', '$2y$10$m.IwjLaIRTAoogWavl08feUfEpdlQyFeyP9i.1LXBrsiy5qRyQyOu', 'Demo', 0, '2024-02-06 17:19:21', 'darwin-vegher.jpg'),
(7, 'test@gmail.com', '$2y$10$zQdeIOXYKSQicDign7ZwT.lDhGLcU7RmDpqwt3UHOvv9ma9Nli6Ym', 'Demo 7', 0, '2024-02-23 09:34:16', NULL),
(8, 'azazaza@azazaza.com', '$2y$10$V90Sm2xOfb2xmjtpkw7PLuwMQsxsFIkHp6.okL6SHsSCwjxyD7NyS', 'Demo 8', 0, '2024-04-25 15:30:45', NULL),
(9, 'alala@alala.com', '$2y$10$ffi9imixl233jstdzb2tcezyYa7IhK9uh5Ji6zxFzcdudTZq4Cnmu', 'alala', 0, '2024-05-06 15:55:34', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_sender` (`id_sender`),
  ADD KEY `fk_id_receiver` (`id_receiver`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_id_receiver` FOREIGN KEY (`id_receiver`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_id_sender` FOREIGN KEY (`id_sender`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
