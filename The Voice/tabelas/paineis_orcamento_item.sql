-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Fev 12, 2014 as 01:09 PM
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
-- Estrutura da tabela `paineis_orcamento_item`
--

CREATE TABLE IF NOT EXISTS `paineis_orcamento_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `painel_orcamento_id` int(11) NOT NULL,
  `painel_id` int(11) NOT NULL,
  `painel_plano_id` int(11) NOT NULL,
  `painel_tipo_midia_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `quantidade_insercoes` int(11) NOT NULL,
  `valor_insercao_initaria` float NOT NULL,
  `valor_total_insercoes` double NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `obs` text NOT NULL,
  `frequencia` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;
