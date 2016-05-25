-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Mer 25 Mai 2016 à 16:18
-- Version du serveur :  5.5.42
-- Version de PHP :  7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `tinggi`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_RANDOM_POST` ()  NO SQL
BEGIN

DECLARE id INT DEFAULT 0;

SELECT * FROM post_view
ORDER BY RAND()
LIMIT 2;

END$$

--
-- Fonctions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `GET_SCORE_COMMENT` (`id` INT) RETURNS INT(11) NO SQL
BEGIN
DECLARE score INT DEFAULT 0;

SELECT SUM(counter.love)
INTO score
FROM (

(SELECT SUM(c.love) AS love
FROM score_comment c
WHERE c.id_comment = id)

UNION

(SELECT 0 AS love)

) counter;

RETURN score;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GET_SCORE_POST` (`id` INT) RETURNS INT(11) NO SQL
BEGIN
DECLARE score INT DEFAULT 0;

SELECT SUM(counter.love)
INTO score
FROM ((

SELECT SUM(p.love) as love
FROM score_post p
WHERE p.id_post = id

) UNION (

SELECT 0 as love

)) counter;


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
-- Doublure de structure pour la vue `best_posts`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `best_posts` (
`id` int(11)
,`type` enum('EMBED','PHOTO','TEXT','IFRAME')
,`title` varchar(50)
,`description` text
,`time` timestamp
,`author` int(11)
,`score` int(11)
);

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

--
-- Contenu de la table `post`
--

INSERT INTO `post` (`id`, `type`, `title`, `description`, `time`, `author`) VALUES
(1, 'TEXT', 'Pingouin', 'C\'est un pingouin. Il respire par les fesses. Un jour, il s\'assoit et il meurt.', '2016-05-25 11:38:09', 1),
(2, 'TEXT', 'C\'est un mec', 'C\'est un mec, il rentre dans un bar. Il rentre dans une chaise, il rentre dans une table, il rentre dans un cheval, il rentre dans Marion.', '2016-05-25 11:40:48', 4),
(3, 'TEXT', 'Ville des paris', 'Quelle est la ville des paris ? Le Cap.\r\nParce que t\'es cap ou t\'es pas cap.', '2016-05-25 11:41:52', 3),
(4, 'TEXT', 'Le belge', 'C\'est un belge, il vérifie ses clignotants, et il dit: "Ca marche, ca marche pas, ca marche, ca marche pas, ca marche, ..."', '2016-04-10 22:00:00', 4);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `post_view`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `post_view` (
`id` int(11)
,`type` enum('EMBED','PHOTO','TEXT','IFRAME')
,`title` varchar(50)
,`description` text
,`time` timestamp
,`author` int(11)
,`score` int(11)
);

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

--
-- Contenu de la table `score_post`
--

INSERT INTO `score_post` (`id_user`, `id_post`, `love`) VALUES
(2, 2, 1),
(2, 3, -1),
(3, 3, -1);

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
(1, 'admin', 'admin@tinggi.fr', 'test', NULL),
(2, 'Céline', 'celine@tinggi.fr', 'celine', NULL),
(3, 'Mélodie', 'melodie@tinggi.fr', 'melodie', NULL),
(4, 'Bacon', 'bacon@tinggi.fr', 'bacon', NULL);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `user_view`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `user_view` (
`id` int(11)
,`pseudo` varchar(30)
,`mail` varchar(50)
,`img` varchar(200)
,`score` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Structure de la vue `best_posts`
--
DROP TABLE IF EXISTS `best_posts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `best_posts`  AS  select `post_view`.`id` AS `id`,`post_view`.`type` AS `type`,`post_view`.`title` AS `title`,`post_view`.`description` AS `description`,`post_view`.`time` AS `time`,`post_view`.`author` AS `author`,`post_view`.`score` AS `score` from `post_view` where (`post_view`.`time` > (curdate() - interval 30 day)) order by `post_view`.`score` desc limit 10 ;

-- --------------------------------------------------------

--
-- Structure de la vue `post_view`
--
DROP TABLE IF EXISTS `post_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `post_view`  AS  select `p`.`id` AS `id`,`p`.`type` AS `type`,`p`.`title` AS `title`,`p`.`description` AS `description`,`p`.`time` AS `time`,`p`.`author` AS `author`,`GET_SCORE_POST`(`p`.`id`) AS `score` from `post` `p` ;

-- --------------------------------------------------------

--
-- Structure de la vue `user_view`
--
DROP TABLE IF EXISTS `user_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_view`  AS  select `u`.`id` AS `id`,`u`.`pseudo` AS `pseudo`,`u`.`mail` AS `mail`,`u`.`img` AS `img`,sum(`p`.`score`) AS `score` from (`user` `u` join `post_view` `p` on((`u`.`id` = `p`.`author`))) group by `u`.`id` ;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
