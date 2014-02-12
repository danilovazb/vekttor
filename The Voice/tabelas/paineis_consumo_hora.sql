-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Fev 12, 2014 as 01:07 PM
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
-- Estrutura da tabela `paineis_consumo_hora`
--

CREATE TABLE IF NOT EXISTS `paineis_consumo_hora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `segundos` time NOT NULL,
  `insercoes` int(11) NOT NULL,
  `data` date NOT NULL,
  `painel_orcamento_tipo_veiculacao_id` int(11) NOT NULL,
  `painel_orcamento_item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `painel_orcamento_item_id` (`painel_orcamento_item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=132 ;
