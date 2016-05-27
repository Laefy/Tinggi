-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost:3306
-- Généré le :  Ven 27 Mai 2016 à 09:56
-- Version du serveur :  5.5.42
-- Version de PHP :  5.6.10

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `TOGGLE_DISLIKE` (IN `user` INT, IN `post` INT)  NO SQL
BEGIN

IF (NOT EXISTS (SELECT love FROM score_post WHERE id_user = user AND id_post = post))
THEN
	INSERT INTO score_post(id_user, id_post, love)
    VALUES (user, post, -1);

ELSE
	UPDATE score_post s
	SET love = - (love + 2) / 3
    WHERE id_user = user AND id_post = post;

END IF;

SELECT love
FROM score_post
WHERE id_user = user AND id_post = post;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TOGGLE_LIKE` (IN `user` INT, IN `post` INT)  NO SQL
BEGIN

IF (NOT EXISTS (SELECT love FROM score_post WHERE id_user = user AND id_post = post))
THEN
	INSERT INTO score_post(id_user, id_post, love)
    VALUES (user, post, 1);

ELSE
	UPDATE score_post s
	SET love = (1 - (love + 1) / 2)
    WHERE id_user = user AND id_post = post;

END IF;

SELECT love
FROM score_post
WHERE id_user = user AND id_post = post;


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
--
CREATE TABLE `best_posts` (
`id` int(11)
,`title` varchar(100)
,`description` text
,`time` timestamp
,`author` int(11)
,`score` int(11)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `best_users`
--
CREATE TABLE `best_users` (
`id` int(11)
,`pseudo` varchar(30)
,`mail` varchar(50)
,`img` varchar(200)
,`score` decimal(32,0)
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
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `post`
--

INSERT INTO `post` (`id`, `title`, `description`, `time`, `author`) VALUES
(1, 'Pingouin', 'C\'est un pingouin. Il respire par les fesses. Un jour, il s\'assoit et il meurt.', '2016-05-25 11:38:09', 1),
(2, 'C\'est un mec', 'C\'est un mec, il rentre dans un bar. Il rentre dans une chaise, il rentre dans une table, il rentre dans un cheval, il rentre dans Marion.', '2016-05-25 11:40:48', 4),
(3, 'Ville des paris', 'Quelle est la ville des paris ? Le Cap.\r\nParce que t\'es cap ou t\'es pas cap.', '2016-05-25 11:41:52', 3),
(4, 'test', 'bsilsidb', '2016-05-26 22:54:04', 9),
(5, 'test', '					test', '2016-05-27 02:06:12', 55),
(6, 'test', '					', '2016-05-27 02:22:17', 55),
(7, 'un test video', 'vid:https://www.youtube.com/watch?v=O8yix8PZKlw\n					une video', '2016-05-27 02:57:11', 55),
(8, 'Test image', 'img:http://media.tumblr.com/tumblr_mbjin0qrBL1r4fuk0.gif\n					un test', '2016-05-27 03:37:05', 55);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `post_view`
--
CREATE TABLE `post_view` (
`id` int(11)
,`title` varchar(100)
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
(1, 1, -1),
(1, 2, 1),
(2, 2, 1),
(2, 3, 0),
(3, 3, -1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(30) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `mail`, `password`, `img`) VALUES
(1, 'admin', 'admin@tinggi.fr', '8f51578495cc264abae6ce12651c0d93', 'test.jpg'),
(2, 'Céline', 'celine@tinggi.fr', '8f51578495cc264abae6ce12651c0d93', NULL),
(3, 'Mélodie', 'melodie@tinggi.fr', '8f51578495cc264abae6ce12651c0d93', NULL),
(4, 'Bacon', 'bacon@tinggi.fr', '8f51578495cc264abae6ce12651c0d93', NULL),
(9, 'GrÃ©goire', 'gregoire@test.com', '8f51578495cc264abae6ce12651c0d93', 'default.png'),
(11, 'test', 'test@test.com', 'd5e309b16e48b128344918ea831fd257', 'default.png'),
(13, 'test2', 'test2@test.com', 'd5e309b16e48b128344918ea831fd257', 'default.png'),
(16, 'k', '', '007fb3d811d0c3a1325f7cc71f250d1b', 'default.png'),
(17, '', 'joug', '007fb3d811d0c3a1325f7cc71f250d1b', 'default.png'),
(18, 'sss', 'lbdsq', 'd8072cc5f823ef6ef47f1053183cdc4e', 'default.png'),
(19, 'dad', 'fan', '292a9679a01240966de67d004cd82cb7', 'default.png'),
(20, 'sfs', 'sqf', 'ac6049cfc94238dbf7c1cefba821ff67', 'default.png'),
(29, 'sdwdohdops', 'ssdsfsfsfsdqsf', 'd992d49b8b97b8b52f1915b304bd8052', 'default.png'),
(31, 'qssqf', 'sqffsfs', '906b6bd5211f36b83ee5639d22db4eda', 'default.png'),
(32, 'sqfsfsqfsqfs', 'sqfqsfsfsqfsqfs', 'b11d4cb3ec514bad81a3cdad4f73e928', 'default.png'),
(33, 'sdsqfqsfsqf', 'qsfq', 'b4e9ef98925ef9acac8b8d94556f6106', 'default.png'),
(47, 'sdnkqsfn@', 'bkdlbflq@', '36653f863ff82c5143eec6cfe6f13244', 'default.png'),
(55, 'melo', 'melo@melo.fr', 'd5e309b16e48b128344918ea831fd257', '');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `user_view`
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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `best_posts`  AS  select `post_view`.`id` AS `id`,`post_view`.`title` AS `title`,`post_view`.`description` AS `description`,`post_view`.`time` AS `time`,`post_view`.`author` AS `author`,`post_view`.`score` AS `score` from `post_view` order by `post_view`.`score` desc limit 10 ;

-- --------------------------------------------------------

--
-- Structure de la vue `best_users`
--
DROP TABLE IF EXISTS `best_users`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `best_users`  AS  select `user_view`.`id` AS `id`,`user_view`.`pseudo` AS `pseudo`,`user_view`.`mail` AS `mail`,`user_view`.`img` AS `img`,`user_view`.`score` AS `score` from `user_view` order by `user_view`.`score` desc limit 10 ;

-- --------------------------------------------------------

--
-- Structure de la vue `post_view`
--
DROP TABLE IF EXISTS `post_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `post_view`  AS  select `p`.`id` AS `id`,`p`.`title` AS `title`,`p`.`description` AS `description`,`p`.`time` AS `time`,`p`.`author` AS `author`,`GET_SCORE_POST`(`p`.`id`) AS `score` from `post` `p` ;

-- --------------------------------------------------------

--
-- Structure de la vue `user_view`
--
DROP TABLE IF EXISTS `user_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_view`  AS  select `u`.`id` AS `id`,`u`.`pseudo` AS `pseudo`,`u`.`mail` AS `mail`,`u`.`img` AS `img`,sum(`p`.`score`) AS `score` from (`user` `u` left join `post_view` `p` on((`u`.`id` = `p`.`author`))) group by `u`.`id` ;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fkey_author_comment_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkey_target_post` FOREIGN KEY (`target`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fkey_author_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `score_comment`
--
ALTER TABLE `score_comment`
  ADD CONSTRAINT `fkey_id_comment_comment` FOREIGN KEY (`id_comment`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkey_id_user_user_score_comment` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `score_post`
--
ALTER TABLE `score_post`
  ADD CONSTRAINT `fkey_id_post_post` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkey_id_user_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
