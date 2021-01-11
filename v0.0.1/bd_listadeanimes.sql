-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 02-Set-2020 às 00:24
-- Versão do servidor: 10.4.10-MariaDB
-- versão do PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `animes`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `listadeanimes`
--

DROP TABLE IF EXISTS `listadeanimes`;
CREATE TABLE IF NOT EXISTS `listadeanimes` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `temporada` varchar(999) NOT NULL,
  `episodio` int(255) NOT NULL,
  `url` varchar(999) NOT NULL,
  `home` varchar(30) NOT NULL,
  `foto` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `listadeanimes`
--

INSERT INTO `listadeanimes` (`id`, `nome`, `temporada`, `episodio`, `url`, `home`, `foto`) VALUES
(7, 'Naruto', '1', 7, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/07.MP4', '', ''),
(6, 'Naruto', '1', 6, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/06.MP4', '', ''),
(5, 'Naruto', '1', 5, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/05.MP4', '', ''),
(4, 'Naruto', '1', 4, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/04.MP4', '', ''),
(3, 'Naruto', '1', 3, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/01.MP4 ', '', ''),
(2, 'Naruto', '1', 2, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/02.MP4', '', ''),
(1, 'Naruto', '1', 1, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/01.MP4', 'sim', 'capa-naruto.jpg'),
(8, 'Naruto', '1', 8, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/08.MP4', 'sim', 'capa-naruto.jpg'),
(9, 'Naruto', '1', 9, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/09.MP4', '', ''),
(10, 'Naruto', '1', 10, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/10.MP4', '', ''),
(11, 'Naruto', '1', 11, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/11.MP4', '', ''),
(12, 'Naruto', '1', 12, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/13.MP4', '', ''),
(13, 'Naruto', '1', 14, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/14.MP4', '', ''),
(14, 'Naruto', '1', 15, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/15.MP4', '', ''),
(15, 'Naruto', '1', 16, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/16.MP4', '', ''),
(16, 'Naruto', '1', 17, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/17.MP4', '', ''),
(17, 'Naruto', '1', 18, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/18.MP4', '', ''),
(18, 'Naruto', '1', 19, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/19.MP4', '', ''),
(19, 'Naruto', '1', 20, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/20.MP4', '', ''),
(20, 'Naruto', '1', 21, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/21.MP4', '', ''),
(21, 'Naruto', '1', 22, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/22.MP4', '', ''),
(22, 'Naruto', '1', 23, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/23.MP4', '', ''),
(23, 'Naruto', '1', 24, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/24.MP4', '', ''),
(24, 'Naruto', '1', 25, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/N/naruto-classico-dublado/25.MP4', '', ''),
(25, 'Dragon-ball-z', '1', 1, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/01.MP4', 'sim', 'capa-dbz.jpg'),
(26, 'Dragon-ball-z', '1', 2, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/02.MP4', 'sim', 'capa-dbz.jpg'),
(27, 'Dragon-ball-z', '1', 3, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/03.MP4', '', ''),
(28, 'Dragon-ball-z', '1', 4, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/04.MP4', '', ''),
(29, 'Dragon-ball-z', '1', 5, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/05.MP4', '', ''),
(30, 'Dragon-ball-z', '1', 6, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/06.MP4', '', ''),
(31, 'Dragon-ball-z', '1', 7, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/07.MP4', '', ''),
(32, 'Dragon-ball-z', '1', 8, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/08.MP4', '', ''),
(33, 'Dragon-ball-z', '1', 9, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/09.MP4', '', ''),
(34, 'Dragon-ball-z', '1', 10, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/10.MP4', '', ''),
(35, 'Dragon-ball-z', '1', 11, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/11.MP4', '', ''),
(36, 'Dragon-ball-z', '1', 12, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/12.MP4', '', ''),
(37, 'Dragon-ball-z', '1', 13, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/13.MP4', '', ''),
(38, 'Dragon-ball-z', '1', 14, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/14.MP4', '', ''),
(39, 'Dragon-ball-z', '1', 15, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/15.MP4', '', ''),
(40, 'Dragon-ball-z', '1', 16, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/16.MP4', '', ''),
(41, 'Dragon-ball-z', '1', 17, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/17.MP4', '', ''),
(42, 'Dragon-ball-z', '1', 18, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/18.MP4', '', ''),
(43, 'Dragon-ball-z', '1', 19, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/19.MP4', '', ''),
(45, 'Dragon-ball-z', '1', 20, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/21.MP4', '', ''),
(46, 'Dragon-ball-z', '1', 22, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/22.MP4', '', ''),
(47, 'Dragon-ball-z', '1', 23, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/23.MP4', '', ''),
(48, 'Dragon-ball-z', '1', 24, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/24.MP4', '', ''),
(49, 'Dragon-ball-z', '1', 25, 'https://ns569568.ip-51-79-82.net/Uploads/Animes/D/dragon-ball-z-dublado-2-temporada-dublado/25.MP4', '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
