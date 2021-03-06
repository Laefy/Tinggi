-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2016 at 01:09 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tinggy`
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

DROP PROCEDURE IF EXISTS `POST_WIN`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `POST_WIN` (IN `id` INT)  NO SQL
BEGIN

UPDATE post p
SET p.win = p.win + 1
WHERE p.id = id;

END$$

DROP PROCEDURE IF EXISTS `SIGN_IN`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SIGN_IN` (IN `login` VARCHAR(50), IN `password` VARCHAR(50))  NO SQL
BEGIN

DECLARE id INT DEFAULT 0;

SELECT u.id INTO id FROM user u WHERE
((u.mail LIKE login) OR (u.pseudo LIKE login))
AND (u.password LIKE password)
LIMIT 1;

SELECT id;

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
DROP FUNCTION IF EXISTS `GET_DISLIKES_POST`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `GET_DISLIKES_POST` (`id` INT) RETURNS INT(11) NO SQL
BEGIN
DECLARE likes INT DEFAULT 0;

SELECT SUM(counter.love)
INTO likes
FROM ((

SELECT SUM(s.love) as love
FROM score_post s
WHERE s.id_post = id AND s.love = -1

) UNION (

SELECT 0
    
)) counter;


RETURN likes;

END$$

DROP FUNCTION IF EXISTS `GET_LIKES_POST`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `GET_LIKES_POST` (`id` INT) RETURNS INT(11) NO SQL
BEGIN
DECLARE likes INT DEFAULT 0;

SELECT SUM(counter.love)
INTO likes
FROM ((

SELECT SUM(s.love) as love
FROM score_post s
WHERE s.id_post = id AND s.love = 1

) UNION (

SELECT 0
    
)) counter;


RETURN likes;

END$$

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

SELECT SUM(s.love) as love
FROM score_post s
WHERE s.id_post = id

) UNION (

SELECT p.win
FROM post p
WHERE p.id = id

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
,`title` varchar(100)
,`description` text
,`time` timestamp
,`author` int(11)
,`score` int(11)
,`likes` int(11)
,`dislikes` int(11)
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
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int(11) NOT NULL,
  `win` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `author` (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `post` (`id`, `title`, `description`, `time`, `author`, `win`) VALUES
(2, 'Hydra Captain America', 'img:http://img-9gag-fun.9cache.com/photo/am9E9Vo_700b_v2.jpg\nTra?tre', '2016-05-27 12:27:18', 1, 0),
(3, 'Sloth', 'vid:https://www.youtube.com/watch?v=fjuzCS5_tMY\nSloth', '2016-05-27 12:28:06', 1, 0),
(4, 'Un chat qui aime manger', 'img:http://charityowl.com/wp-content/uploads/2016/05/funny-cat-meme-17-charity-owl.jpg\nNom nom nom', '2016-05-27 12:29:21', 1, 0),
(6, 'L?zard', 'img:http://apikabu.ru/img_n/2012-08_5/954.jpg\noui', '2016-05-27 12:30:56', 1, 0),
(7, 'Marmotte', 'img:https://s-media-cache-ak0.pinimg.com/736x/41/54/31/41543117db19bad2dfa0468e49a1c086.jpg\nMarmotte mignonne', '2016-05-27 12:31:31', 1, 0),
(8, 'Situtation sous contr?le', 'img:https://www.humour.com/medias/photos/2013/600x404/l-20130926031606.jpg\nOui', '2016-05-27 12:33:59', 2, 0),
(9, 'Je ne fais que passer', 'img:http://perdstontemps.ca/wp-content/uploads/2013/11/1XPhbDE.gif\nJe ne fais que passer', '2016-05-27 12:34:31', 2, 0),
(10, 'Game of Thrones Marcheur Blanc', 'img:https://k60.kn3.net/taringa/3/0/4/1/B/7/PanighelB/D21.gif\nSwag', '2016-05-27 12:34:54', 2, 0),
(11, 'BAM LA VITRE', 'img:http://perdstontemps.ca/wp-content/uploads/2013/11/0nvq3Cz.gif\nPrend cher le chien', '2016-05-27 12:35:43', 2, 0),
(12, 'Rigolo', 'img:http://m.memegen.com/fbt4ft.jpg\nOui', '2016-05-27 12:37:28', 3, 0),
(13, 'Batman russe', 'vid:https://www.youtube.com/watch?v=Dgf4JjSuMhc\nCoucou Batman', '2016-05-27 12:40:51', 3, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `post_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `post_view`;
CREATE TABLE IF NOT EXISTS `post_view` (
`id` int(11)
,`title` varchar(100)
,`description` text
,`time` timestamp
,`author` int(11)
,`score` int(11)
,`likes` int(11)
,`dislikes` int(11)
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

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(30) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user` (`id`, `pseudo`, `mail`, `password`, `img`) VALUES
(1, 'Quentin', 'quentin.quemere@gmail.com', 'e7eb64985fe1ed189879a55da9940d25', 'default.png'),
(2, 'Bzh', 'coucou@gmail.com', 'e7eb64985fe1ed189879a55da9940d25', 'default.png'),
(3, 'Yolo', 'swag@gmail.com', 'e7eb64985fe1ed189879a55da9940d25', 'default.png');

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `best_posts`  AS  select `post_view`.`id` AS `id`,`post_view`.`title` AS `title`,`post_view`.`description` AS `description`,`post_view`.`time` AS `time`,`post_view`.`author` AS `author`,`post_view`.`score` AS `score`,`post_view`.`likes` AS `likes`,`post_view`.`dislikes` AS `dislikes` from `post_view` order by `post_view`.`score` desc limit 10 ;

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `post_view`  AS  select `p`.`id` AS `id`,`p`.`title` AS `title`,`p`.`description` AS `description`,`p`.`time` AS `time`,`p`.`author` AS `author`,`GET_SCORE_POST`(`p`.`id`) AS `score`,`GET_LIKES_POST`(`p`.`id`) AS `likes`,`GET_DISLIKES_POST`(`p`.`id`) AS `dislikes` from `post` `p` ;

-- --------------------------------------------------------

--
-- Structure for view `user_view`
--
DROP TABLE IF EXISTS `user_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_view`  AS  select `u`.`id` AS `id`,`u`.`pseudo` AS `pseudo`,`u`.`mail` AS `mail`,`u`.`img` AS `img`,sum(`p`.`score`) AS `score` from (`user` `u` left join `post_view` `p` on((`u`.`id` = `p`.`author`))) group by `u`.`id` ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fkey_author_comment_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkey_target_post` FOREIGN KEY (`target`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fkey_author_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `score_comment`
--
ALTER TABLE `score_comment`
  ADD CONSTRAINT `fkey_id_comment_comment` FOREIGN KEY (`id_comment`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkey_id_user_user_score_comment` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `score_post`
--
ALTER TABLE `score_post`
  ADD CONSTRAINT `fkey_id_post_post` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkey_id_user_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
