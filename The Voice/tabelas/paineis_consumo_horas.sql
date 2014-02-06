-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Fev 06, 2014 as 02:09 PM
-- Versão do Servidor: 5.1.44
-- Versão do PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `nv_sistema`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `painel_consumo_horas`
--

CREATE TABLE IF NOT EXISTS `painel_consumo_horas` (
  `id` int(11) NOT NULL,
  `segundos` varchar(10) NOT NULL,
  `insercoes` int(11) NOT NULL,
  `data` date NOT NULL,
  `tipo_midia` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
