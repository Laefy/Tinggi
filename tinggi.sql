-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2016 at 08:57 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tinggi`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `GET_RANDOM_POST`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_RANDOM_POST` ()  NO SQL
BEGIN

DECLARE id INT DEFAULT 0;

SELECT * FROM post_view
ORDER BY RAND()
LIMIT 2;

END$$

DROP PROCEDURE IF EXISTS `TOGGLE_DISLIKE`$$
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

DROP PROCEDURE IF EXISTS `TOGGLE_LIKE`$$
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
-- Functions
--
DROP FUNCTION IF EXISTS `GET_SCORE_COMMENT`$$
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

DROP FUNCTION IF EXISTS `GET_SCORE_POST`$$
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

DROP FUNCTION IF EXISTS `SIGN_IN`$$
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
-- Stand-in structure for view `best_posts`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `best_posts`;
CREATE TABLE IF NOT EXISTS `best_posts` (
`id` int(11)
,`title` varchar(50)
,`description` text
,`time` timestamp
,`author` int(11)
,`score` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `best_users`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `best_users`;
CREATE TABLE IF NOT EXISTS `best_users` (
`id` int(11)
,`pseudo` varchar(30)
,`mail` varchar(50)
,`img` varchar(200)
,`score` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `texte` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `target` (`target`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title`, `description`, `time`, `author`) VALUES
(1, 'Pingouin', 'C\'est un pingouin. Il respire par les fesses. Un jour, il s\'assoit et il meurt.', '2016-05-25 11:38:09', 1),
(2, 'C\'est un mec', 'C\'est un mec, il rentre dans un bar. Il rentre dans une chaise, il rentre dans une table, il rentre dans un cheval, il rentre dans Marion.', '2016-05-25 11:40:48', 4),
(3, 'Ville des paris', 'Quelle est la ville des paris ? Le Cap.\r\nParce que t\'es cap ou t\'es pas cap.', '2016-05-25 11:41:52', 3);

-- --------------------------------------------------------

--
-- Stand-in structure for view `post_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `post_view`;
CREATE TABLE IF NOT EXISTS `post_view` (
`id` int(11)
,`title` varchar(50)
,`description` text
,`time` timestamp
,`author` int(11)
,`score` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `score_comment`
--

DROP TABLE IF EXISTS `score_comment`;
CREATE TABLE IF NOT EXISTS `score_comment` (
  `id_user` int(11) NOT NULL,
  `id_comment` int(11) NOT NULL,
  `love` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user`,`id_comment`),
  KEY `fkey_id_comment_comment` (`id_comment`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `score_post`
--

DROP TABLE IF EXISTS `score_post`;
CREATE TABLE IF NOT EXISTS `score_post` (
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `love` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user`,`id_post`),
  KEY `fkey_id_post_post` (`id_post`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `score_post`
--

INSERT INTO `score_post` (`id_user`, `id_post`, `love`) VALUES
(1, 1, -1),
(1, 2, 1),
(2, 2, 1),
(2, 3, 0),
(3, 3, -1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(30) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `img` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `mail`, `password`, `img`) VALUES
(1, 'admin', 'admin@tinggi.fr', 'test', NULL),
(2, 'Céline', 'celine@tinggi.fr', 'celine', NULL),
(3, 'Mélodie', 'melodie@tinggi.fr', 'melodie', NULL),
(4, 'Bacon', 'bacon@tinggi.fr', 'bacon', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `user_view`;
CREATE TABLE IF NOT EXISTS `user_view` (
`id` int(11)
,`pseudo` varchar(30)
,`mail` varchar(50)
,`img` varchar(200)
,`score` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Structure for view `best_posts`
--
DROP TABLE IF EXISTS `best_posts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `best_posts`  AS  select `post_view`.`id` AS `id`,`post_view`.`title` AS `title`,`post_view`.`description` AS `description`,`post_view`.`time` AS `time`,`post_view`.`author` AS `author`,`post_view`.`score` AS `score` from `post_view` order by `post_view`.`score` desc limit 10 ;

-- --------------------------------------------------------

--
-- Structure for view `best_users`
--
DROP TABLE IF EXISTS `best_users`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `best_users`  AS  select `user_view`.`id` AS `id`,`user_view`.`pseudo` AS `pseudo`,`user_view`.`mail` AS `mail`,`user_view`.`img` AS `img`,`user_view`.`score` AS `score` from `user_view` order by `user_view`.`score` desc limit 10 ;

-- --------------------------------------------------------

--
-- Structure for view `post_view`
--
DROP TABLE IF EXISTS `post_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `post_view`  AS  select `p`.`id` AS `id`,`p`.`title` AS `title`,`p`.`description` AS `description`,`p`.`time` AS `time`,`p`.`author` AS `author`,`GET_SCORE_POST`(`p`.`id`) AS `score` from `post` `p` ;

-- --------------------------------------------------------

--
-- Structure for view `user_view`
--
DROP TABLE IF EXISTS `user_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_view`  AS  select `u`.`id` AS `id`,`u`.`pseudo` AS `pseudo`,`u`.`mail` AS `mail`,`u`.`img` AS `img`,sum(`p`.`score`) AS `score` from (`user` `u` join `post_view` `p` on((`u`.`id` = `p`.`author`))) group by `u`.`id` ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fkey_author_comment_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fkey_target_post` FOREIGN KEY (`target`) REFERENCES `post` (`id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fkey_author_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`);

--
-- Constraints for table `score_comment`
--
ALTER TABLE `score_comment`
  ADD CONSTRAINT `fkey_id_comment_comment` FOREIGN KEY (`id_comment`) REFERENCES `comment` (`id`),
  ADD CONSTRAINT `fkey_id_user_user_score_comment` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Constraints for table `score_post`
--
ALTER TABLE `score_post`
  ADD CONSTRAINT `fkey_id_post_post` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `fkey_id_user_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
