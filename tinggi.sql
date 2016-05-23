-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 23 Mai 2016 à 16:06
-- Version du serveur :  10.1.13-MariaDB
-- Version de PHP :  5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `tinggi`
--

DELIMITER $$
--
-- Fonctions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `GET_SCORE_COMMENT` (`id` INT) RETURNS INT(11) NO SQL
BEGIN
DECLARE score INT DEFAULT 0;

SELECT SUM(love) 
INTO score 
FROM (
    
(SELECT 1 AS love 
FROM score_comment c 
WHERE c.love = 1 AND c.id_comment = id)

UNION 

(SELECT -1 AS love 
FROM score_comment sc 
WHERE sc.love = 0 AND sc.id_comment = id)
    
) counter;

RETURN score;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GET_SCORE_POST` (`id` INT) RETURNS INT(11) NO SQL
BEGIN
DECLARE score INT DEFAULT 0;

SELECT SUM(love) 
INTO score 
FROM (
    
(SELECT 1 AS love 
FROM score_post p
WHERE p.love = 1 AND p.id_comment = id)

UNION 

(SELECT -1 AS love 
FROM score_post sp 
WHERE sp.love = 0 AND sp.id_comment = id)
    
) counter;

RETURN score;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `SIGN_IN` (`login` VARCHAR(50), `password` VARCHAR(50)) RETURNS INT(11) NO SQL
BEGIN

DECLARE id INT DEFAULT 0;

SELECT u.id INTO id FROM user u WHERE 
((u.mail LIKE login) OR (u.pseudo LIKE login))
AND (u.password LIKE password)
LIMIT 1;

RETURN id;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `texte` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `type` enum('EMBED','PHOTO','TEXT','IFRAME') NOT NULL DEFAULT 'TEXT',
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `score_comment`
--

CREATE TABLE `score_comment` (
  `id_user` int(11) NOT NULL,
  `id_comment` int(11) NOT NULL,
  `love` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `score_post`
--

CREATE TABLE `score_post` (
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `love` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(30) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `img` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `mail`, `password`, `img`) VALUES
(1, 'admin', 'admin@tinggi.fr', 'test', NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author`),
  ADD KEY `target` (`target`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author`);

--
-- Index pour la table `score_comment`
--
ALTER TABLE `score_comment`
  ADD PRIMARY KEY (`id_user`,`id_comment`),
  ADD KEY `fkey_id_comment_comment` (`id_comment`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `score_post`
--
ALTER TABLE `score_post`
  ADD PRIMARY KEY (`id_user`,`id_post`),
  ADD KEY `fkey_id_post_post` (`id_post`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fkey_author_comment_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fkey_target_post` FOREIGN KEY (`target`) REFERENCES `post` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fkey_author_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `score_comment`
--
ALTER TABLE `score_comment`
  ADD CONSTRAINT `fkey_id_comment_comment` FOREIGN KEY (`id_comment`) REFERENCES `comment` (`id`),
  ADD CONSTRAINT `fkey_id_user_user_score_comment` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `score_post`
--
ALTER TABLE `score_post`
  ADD CONSTRAINT `fkey_id_post_post` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `fkey_id_user_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
