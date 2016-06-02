-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/06/2016 às 18:57
-- Versão do servidor: 5.6.15-log
-- Versão do PHP: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `helpdesk`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `acessos`
--

CREATE TABLE IF NOT EXISTS `acessos` (
  `id_acesso` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `data_in` varchar(50) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  PRIMARY KEY (`id_acesso`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `acessos`
--

INSERT INTO `acessos` (`id_acesso`, `codigo`, `data_in`, `ip`, `login`) VALUES
(1, '0', '1464904632', '127.0.0.1', 'ADMIN');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamados`
--

CREATE TABLE IF NOT EXISTS `chamados` (
  `numero` int(4) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `status` varchar(1) NOT NULL,
  `agente` varchar(50) NOT NULL,
  `codigo` int(1) NOT NULL,
  `abertura` int(50) NOT NULL,
  `clientes` varchar(50) NOT NULL,
  `aviso` int(1) NOT NULL,
  `descricao` text NOT NULL,
  `fechamento` int(11) NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `acoes` text NOT NULL,
  `sla` varchar(50) NOT NULL,
  `solucao` text NOT NULL,
  `obs` text NOT NULL,
  `obs_cli` text NOT NULL,
  `prog` int(11) NOT NULL,
  `hinicio` int(11) NOT NULL,
  `hfim` int(11) NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `cod_usuario` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `nick` varchar(50) NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `last_upd` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `usuarios`
--

INSERT INTO `usuarios` (`cod_usuario`, `username`, `senha`, `tipo`, `nome`, `nick`, `departamento`, `last_upd`, `status`, `id`, `email`) VALUES
(0, 'admin', 'e99c9f59aba831a3e5d010836f94fbf76b81a065', '1', 'administrador', 'admin', 'administrador', '', 1, 1, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
