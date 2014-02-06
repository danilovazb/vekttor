-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Fev 06, 2014 as 07:12 PM
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
-- Estrutura da tabela `paineis`
--

CREATE TABLE IF NOT EXISTS `paineis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vkt_id` int(11) NOT NULL,
  `financeiro_conta_id` int(11) NOT NULL,
  `financeiro_centro_de_custo_id` int(11) NOT NULL,
  `financeiro_plano_de_conta_id` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `endereco` varchar(50) NOT NULL,
  `numero` int(11) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `cidade` varchar(20) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `seg_ini` time NOT NULL,
  `seg_fim` time NOT NULL,
  `ter_ini` time NOT NULL,
  `ter_fim` time NOT NULL,
  `qua_ini` time NOT NULL,
  `qua_fim` time NOT NULL,
  `qui_ini` time NOT NULL,
  `qui_fim` time NOT NULL,
  `sex_ini` time NOT NULL,
  `sex_fim` time NOT NULL,
  `sab_ini` time NOT NULL,
  `sab_fim` time NOT NULL,
  `dom_ini` time NOT NULL,
  `dom_fim` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vkt_id` (`vkt_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
