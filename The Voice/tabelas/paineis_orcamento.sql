-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Fev 06, 2014 as 01:54 PM
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
-- Estrutura da tabela `paineis_orcamento`
--

CREATE TABLE IF NOT EXISTS `paineis_orcamento` (
  `id` int(11) NOT NULL,
  `vkt_id` int(11) NOT NULL,
  `cliente_fornecedor_id` int(11) NOT NULL,
  `numero_proposta` int(11) NOT NULL,
  `numero_pi` int(11) NOT NULL,
  `numero_versao` varchar(15) NOT NULL,
  `descricao` varchar(80) NOT NULL,
  `segundos_vt` varchar(20) NOT NULL,
  `cliente_fornecedor_agenda_id` int(11) NOT NULL,
  `cliente_fornecedor_vendedor_Id` int(11) NOT NULL,
  `valor_subtotal` float NOT NULL,
  `desconto_valor` float NOT NULL,
  `desconto_porcentagem` float NOT NULL,
  `valor_total` float NOT NULL,
  `data_orcamento` date NOT NULL,
  `data_validade_proposta` date NOT NULL,
  `data_aprovacao` date NOT NULL,
  `status` enum('orcamento','pi') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
