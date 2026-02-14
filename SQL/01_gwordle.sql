--
-- Database: `gwordle`
--
-- --------------------------------------------------------

START TRANSACTION;

--
-- Create database `gwordle`
--
DROP DATABASE IF EXISTS `gwordle`;
CREATE DATABASE `gwordle`;
USE `gwordle`;

--
-- Create `words` table
--
CREATE TABLE `words` (
  `id` int NOT NULL AUTO_INCREMENT,
  `word` CHAR(5) NOT NULL,
  `wordle` CHAR(5) DEFAULT NULL,
  `day` DATE DEFAULT NULL,
  `ext` BOOLEAN DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Create `gwordle` user
--
DROP USER IF EXISTS `gwordle`@`localhost`;
CREATE USER `gwordle`@`localhost` IDENTIFIED BY '<insert your password here>';
GRANT SELECT,INSERT,UPDATE ON `gwordle`.* TO `gwordle`@`localhost`;

COMMIT;
-- --------------------------------------------------------