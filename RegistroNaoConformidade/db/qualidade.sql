-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/06/2016 às 18:41
-- Versão do servidor: 5.6.15-log
-- Versão do PHP: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `qualidade`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `todo`
--

CREATE TABLE IF NOT EXISTS `todo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `priority` varchar(20) NOT NULL DEFAULT 'Menor',
  `created_on` datetime NOT NULL,
  `due_on` datetime NOT NULL,
  `last_modified_on` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `comment` text,
  `status` enum('PENDENTE','RESOLVIDA','VENCIDO','CANCELADO') NOT NULL DEFAULT 'PENDENTE',
  `andamento` int(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `descricao` text NOT NULL,
  `numero` varchar(6) NOT NULL,
  `origem` varchar(100) NOT NULL,
  `tipoacao` varchar(100) NOT NULL,
  `processo` varchar(100) NOT NULL,
  `identificador` varchar(100) NOT NULL,
  `causa` varchar(100) NOT NULL,
  `imediata` text NOT NULL,
  `corretiva` text NOT NULL,
  `retorno` datetime NOT NULL,
  `implementador` varchar(100) NOT NULL,
  `eliminacao` datetime NOT NULL,
  `eliminacao_novo` datetime NOT NULL,
  `reg_eficacia` text NOT NULL,
  `resp_verificacao` varchar(100) NOT NULL,
  `eficaz` enum('SIM','NÃO') DEFAULT NULL,
  `eficaz_data` datetime NOT NULL,
  `novo_rnc` varchar(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero` (`numero`),
  KEY `priority` (`priority`),
  KEY `due_on` (`due_on`),
  KEY `status` (`status`),
  KEY `deleted` (`deleted`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `deleted` int(1) NOT NULL,
  `senha` varchar(12) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `usuario`
--

INSERT INTO `usuario` (`id`, `login`, `deleted`, `senha`) VALUES
(1, 'ADMIN', 0, 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
