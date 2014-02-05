-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 12/03/2013 às 10:13:16
-- Versão do Servidor: 5.1.68-cll
-- Versão do PHP: 5.3.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `nv_sistema`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `escolar2_ensino`
--

CREATE TABLE IF NOT EXISTS `escolar2_ensino` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vkt_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `ordem_ensino` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `escolar2_ensino`
--

INSERT INTO `escolar2_ensino` (`id`, `vkt_id`, `nome`, `ordem_ensino`) VALUES
(1, 177, 'Ensino Fundamental', 4),
(2, 177, 'Ensino Médio', 5),
(4, 177, 'Ensino Infantil', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `escolar2_materias`
--

CREATE TABLE IF NOT EXISTS `escolar2_materias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vkt_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Extraindo dados da tabela `escolar2_materias`
--

INSERT INTO `escolar2_materias` (`id`, `vkt_id`, `nome`) VALUES
(39, 177, 'Português'),
(38, 177, 'História'),
(37, 177, 'Ciências'),
(36, 177, 'Matemática'),
(35, 177, 'Português');

-- --------------------------------------------------------

--
-- Estrutura da tabela `escolar2_professores`
--

CREATE TABLE IF NOT EXISTS `escolar2_professores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vkt_id` int(11) NOT NULL,
  `funcionario_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `escola_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vkt_id` (`vkt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `escolar2_salas`
--

CREATE TABLE IF NOT EXISTS `escolar2_salas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vkt_id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `ano` int(11) NOT NULL,
  `unidade_id` int(11) NOT NULL,
  `capacidade_maxima` int(11) NOT NULL,
  `capacidade_pedagogica` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Extraindo dados da tabela `escolar2_salas`
--

INSERT INTO `escolar2_salas` (`id`, `vkt_id`, `nome`, `ano`, `unidade_id`, `capacidade_maxima`, `capacidade_pedagogica`) VALUES
(14, 177, 'sala 1', 0, 3, 10, 10),
(13, 177, 'sala 2', 0, 2, 20, 18),
(9, 177, 'sala 1', 0, 2, 15, 10),
(15, 177, 'sala 2', 0, 3, 20, 20),
(16, 177, 'sala 3', 0, 3, 20, 25);

-- --------------------------------------------------------

--
-- Estrutura da tabela `escolar2_series`
--

CREATE TABLE IF NOT EXISTS `escolar2_series` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vkt_id` int(11) NOT NULL,
  `ensino_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `materias_por_dia` int(11) NOT NULL,
  `ordem_ensino` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Extraindo dados da tabela `escolar2_series`
--

INSERT INTO `escolar2_series` (`id`, `vkt_id`, `ensino_id`, `nome`, `materias_por_dia`, `ordem_ensino`) VALUES
(1, 177, 1, '1ª Sérire', 0, 1),
(2, 177, 1, '2ª Série', 0, 2),
(3, 177, 1, '3ª Série', 0, 3),
(4, 177, 1, '4ª Série', 0, 4),
(5, 177, 1, '5ª Série', 0, 5),
(6, 177, 1, '6ª Série', 0, 6),
(7, 177, 1, '7ª Sérire', 0, 7),
(8, 177, 1, '8ª Série', 0, 8),
(9, 177, 1, '9ª Série', 0, 9),
(10, 177, 2, '1º Ano', 0, 10),
(11, 177, 2, '2º Ano', 0, 11),
(13, 177, 2, '3º Ano', 0, 12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `escolar2_serie_has_materias`
--

CREATE TABLE IF NOT EXISTS `escolar2_serie_has_materias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vkt_id` int(11) NOT NULL,
  `serie_id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `quantidade_de_aulas` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vkt_id` (`vkt_id`,`serie_id`,`materia_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `escolar2_serie_has_materias`
--

INSERT INTO `escolar2_serie_has_materias` (`id`, `vkt_id`, `serie_id`, `materia_id`, `quantidade_de_aulas`) VALUES
(12, 177, 2, 39, 20),
(11, 177, 1, 38, 1),
(10, 177, 1, 37, 20),
(9, 177, 1, 36, 20),
(8, 177, 1, 35, 20);

-- --------------------------------------------------------

--
-- Estrutura da tabela `escolar2_turma`
--

CREATE TABLE IF NOT EXISTS `escolar2_turma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vkt_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `horario_id` int(11) NOT NULL,
  `sala_id` int(11) NOT NULL,
  `unidade_id` int(11) NOT NULL,
  `serie_id` int(11) NOT NULL,
  `periodo_letivo_id` int(11) NOT NULL,
  `turno` enum('manha','tarde','noite') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Extraindo dados da tabela `escolar2_turma`
--

INSERT INTO `escolar2_turma` (`id`, `vkt_id`, `nome`, `horario_id`, `sala_id`, `unidade_id`, `serie_id`, `periodo_letivo_id`, `turno`) VALUES
(13, 0, '', 0, 9, 2, 13, 0, 'manha'),
(12, 0, '', 0, 13, 2, 2, 0, 'manha'),
(14, 0, '', 0, 13, 2, 2, 0, 'tarde'),
(15, 0, '', 0, 9, 2, 5, 0, 'noite'),
(16, 0, '', 0, 15, 3, 1, 0, 'manha'),
(17, 0, '', 0, 14, 3, 2, 0, 'manha'),
(18, 0, '', 0, 14, 3, 1, 0, 'tarde'),
(19, 0, '', 0, 15, 3, 1, 0, 'tarde'),
(20, 0, '', 0, 16, 3, 1, 0, 'noite'),
(21, 0, '', 0, 16, 3, 3, 0, 'manha');

-- --------------------------------------------------------

--
-- Estrutura da tabela `escolar2_unidades`
--

CREATE TABLE IF NOT EXISTS `escolar2_unidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vkt_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cep` varchar(20) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `numero` varchar(5) NOT NULL,
  `complemento` varchar(100) NOT NULL,
  `media` double NOT NULL,
  `qtd_salas` int(11) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `escolar2_unidades`
--

INSERT INTO `escolar2_unidades` (`id`, `vkt_id`, `nome`, `cep`, `endereco`, `bairro`, `cidade`, `estado`, `numero`, `complemento`, `media`, `qtd_salas`, `telefone`, `email`) VALUES
(2, 177, 'FAMETRO UNIDADE I', '69080-430', 'Rua Ouro Preto', 'Coroado', 'Manaus', 'am', '10', 'Próximo ao Manaus Casa Shopping', 5, 0, '(92)2101-8969', 'fametro@fametro.com.br'),
(3, 177, 'FAMETRO UNIDADE II', '69050-001', 'Avenida Constantino Nery', 'Chapada', 'Manaus', 'am', '3000', 'Ao Lado do Manaus Casa Center', 5, 0, '(92)2101-1000', 'secad@fametro.edu.br');

-- --------------------------------------------------------

--
-- Estrutura da tabela `escolar2_unidade_has_ensinos`
--

CREATE TABLE IF NOT EXISTS `escolar2_unidade_has_ensinos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vkt_id` int(11) NOT NULL,
  `unidades_id` int(11) NOT NULL,
  `ensino_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sis_modulos`
--

CREATE TABLE IF NOT EXISTS `sis_modulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modulo_id` int(11) DEFAULT NULL,
  `nome` varchar(255) NOT NULL,
  `ordem_menu` int(11) NOT NULL,
  `tela` varchar(255) NOT NULL,
  `caminho` varchar(255) NOT NULL,
  `acao_menu` enum('expande','abre','form','interno','blank') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=470 ;

--
-- Extraindo dados da tabela `sis_modulos`
--

INSERT INTO `sis_modulos` (`id`, `modulo_id`, `nome`, `ordem_menu`, `tela`, `caminho`, `acao_menu`) VALUES
(1, 0, 'Administrativo', 1, '', '', 'expande'),
(3, 0, 'Estoque', 20, '', '', 'expande'),
(4, 0, 'Monitoramento de Obra 0%', 30, '', '', 'expande'),
(5, 0, 'Financeiro', 40, '', '', 'expande'),
(6, 0, '-', 70, '', '', 'expande'),
(8, 0, 'Imobiliária Construtora', 50, '', '', 'expande'),
(13, 1, 'Usuários', 70, 'index.php', 'modulos/administrativo/usuarios/', 'abre'),
(14, 1, 'Tipos de Usuarios', 80, 'index.php', 'modulos/administrativo/tipos_usuarios/', 'abre'),
(15, 1, 'Clientes', 10, 'index.php', 'modulos/administrativo/clientes/', 'abre'),
(16, 1, 'Fornecedores', 20, 'index.php', 'modulos/administrativo/fornecedores/', 'abre'),
(17, 1, 'Empreendimentos', 30, 'empreendimentos_admin.php', 'modulos/administrativo/empreendimentos/', 'abre'),
(18, 1, 'Obras', 40, 'index.php', 'modulos/administrativo/obras/', 'abre'),
(19, 1, 'Planejamentos / Orçamentos', 60, 'index.php', 'modulos/administrativo/planejamentos', 'abre'),
(20, 1, 'Contrato Imobiliário', 50, 'contratos_admin.php', 'modulos/administrativo/contratos_admin/', 'abre'),
(37, 8, 'Cadastro de Cliente', 10, 'index.php', 'modulos/corretor/cadastro_clientes/', 'abre'),
(38, 8, 'Vendas', 40, 'index.php', 'modulos/corretor/vendas/', 'abre'),
(39, 8, 'Empreendimentos', 20, 'empreendimentos_corretor.php', 'modulos/corretor/empreendimentos', 'abre'),
(41, 13, 'Histórico', 0, 'historico.php', 'modulos/administrativo/usuarios/', 'interno'),
(42, 3, 'Inventário', 90, 'index_inventarios.php', 'modulos/estoque/inventarios', 'abre'),
(45, 3, 'Cotação', 25, 'necessidade_cotacao.php', 'modulos/cozinha/cotacao/', 'abre'),
(47, 4, 'Acompanhamento', 0, '', '', 'expande'),
(48, 4, 'Autorização de Pagamento', 0, '', '', ''),
(49, 5, 'Contas', 10, 'contas.php', 'modulos/financeiro/contas/', 'abre'),
(50, 5, 'Centro de Custos', 20, 'centro_de_custos.php', 'modulos/financeiro/centro_de_custos/', 'abre'),
(51, 5, 'Plano de Contas', 30, 'plano_de_contas.php', 'modulos/financeiro/plano_de_contas/', 'abre'),
(52, 5, 'Contas a Pagar', 50, 'contas_a_pagar.php', 'modulos/financeiro/contas_a_pagar/', 'abre'),
(53, 5, 'Contas a Receber', 40, 'contas_a_receber.php', 'modulos/financeiro/contas_a_receber/', ''),
(54, 5, 'Caixa', 60, 'caixa.php', 'modulos/financeiro/caixa/', 'abre'),
(56, 6, 'Backup', 0, '', '', ''),
(57, 6, 'Alimentar Dados', 0, '', '', ''),
(58, 17, 'Negociações', 0, 'negociacao.php', 'modulos/administrativo/empreendimentos/negociacao/', 'interno'),
(60, 17, 'Disponibilidades', 0, 'disponibilidade.php', 'modulos/administrativo/empreendimentos/disponibilidades/', 'interno'),
(61, 60, 'Reservas', 0, 'index.php', 'modulos/administrativo/empreendimentos/disponibilidades/reservas/', 'interno'),
(62, 17, 'Planejamentos / Orçamentos', 0, 'index.php', 'modulos/administrativo/planejamentos', 'interno'),
(65, 17, 'Tipos de Disponibilidades', 0, 'disponibilidade_tipo.php', 'modulos/administrativo/empreendimentos/disponibilidade_tipo/', 'interno'),
(66, 39, 'Disponibilidades', 0, 'disponibilidade.php', 'modulos/corretor/empreendimentos/disponibilidades/', 'interno'),
(67, 8, 'Interesses', 30, 'index.php', 'modulos/corretor/interesses/', 'abre'),
(68, 37, 'Arquivos', 0, 'index.php', 'modulos/corretor/cadastro_clientes/arquivos/', 'interno'),
(69, 15, 'Arquivos', 0, 'index.php', 'modulos/administrativo/clientes/arquivos/', 'interno'),
(70, 20, 'Detalhes Contrato', 0, 'exibicao_contrato.php', 'modulos/administrativo/contratos_admin', 'abre'),
(78, 71, 'Inventários', 1, 'inventarios.php', 'modulos/estoque/produtos/', 'interno'),
(79, 5, 'Relatorios', 100, '', '', 'expande'),
(80, 5, 'Fluxo de Caixa', 65, 'fluxo_caixa.php', 'modulos/financeiro/fluxo_caixa/', 'abre'),
(82, 79, 'Anual', 0, 'demonstrativo_anual.php', 'modulos/financeiro/relatorios/demonstrativo_anual/', 'abre'),
(83, 50, 'Planejamento', 0, 'planejamento_centro_de_custos.php', 'modulos/financeiro/centro_de_custos/', 'abre'),
(84, 51, 'Planejamento', 0, 'planejamento_plano_de_conta.php', 'modulos/financeiro/plano_de_contas/', 'abre'),
(85, 79, 'Busca por Período', 0, 'busca.php', 'modulos/financeiro/relatorios/busca/', 'abre'),
(86, 5, 'Contas Fixas', 67, 'contas_fixas.php', 'modulos/financeiro/contas_fixas/', 'abre'),
(87, 5, 'Financiamentos ', 68, 'contratos.php', 'modulos/financeiro/contratos/', 'abre'),
(88, 5, 'Cheques', 69, 'cheques.php', 'modulos/financeiro/cheques/', 'abre'),
(89, 0, 'Controle de Atividades', 60, '', '', 'expande'),
(90, 89, 'Tipo de Atividade', 20, 'tipo_atividades.php', 'modulos/projetos/tipo_atividades/', 'abre'),
(91, 89, 'Projetos', 0, 'projetos.php', 'modulos/projetos/', 'abre'),
(92, 89, 'Atividades', 30, 'atividades.php', 'modulos/projetos/atividades', 'abre'),
(93, 0, 'RH', 60, '', '', 'expande'),
(94, 93, 'Funcionarios', 10, 'funcionarios.php', 'modulos/rh/funcionarios/', 'abre'),
(95, 98, 'Relatório Funcionários', 1, 'relatorio_funcionario.php', 'modulos/projetos/relatorios/', 'abre'),
(96, 89, 'Colaborador', 10, 'colaborador.php', 'modulos/projetos/atividades/colaborador', 'abre'),
(97, 98, 'Relatório Projetos', 10, 'relatorio_projeto.php', 'modulos/projetos/relatorios/', 'abre'),
(98, 89, 'Relatórios', 40, '', '', 'expande'),
(99, 0, 'Cozinha', 60, '', '', 'expande'),
(101, 99, 'Cardapio', 20, 'cardapio.php', 'modulos/cozinha/cardapio/', 'abre'),
(102, 99, 'Ficha Técnica', 2, 'ficha_tecnica.php', 'modulos/cozinha/ficha_tecnica/', 'abre'),
(103, 3, 'Almoxarifado', 0, 'unidades.php', 'modulos/estoque/almoxarifado/', 'abre'),
(104, 99, 'Contrato', 10, 'contrato.php', 'modulos/cozinha/contrato/', 'abre'),
(107, 3, 'Produtos', 10, 'index.php', 'modulos/estoque/produtos/', 'abre'),
(108, 3, 'Produtos por Fornecedor', 20, 'produtos_fornecedor.php', 'modulos/estoque/produtos_fornecedor/', 'abre'),
(109, 3, 'Beneficiamento', 70, 'beneficiamento.php', 'modulos/estoque/beneficiamento/', 'abre'),
(110, 3, 'Compras', 30, 'compras.php', 'modulos/estoque/compras/', 'abre'),
(111, 99, 'Grupo Fichas Técnicas', 1, 'grupo_cardapio.php', 'modulos/cozinha/grupo_cardapio', 'abre'),
(112, 99, 'Quebra', 80, 'quebra.php', 'modulos/cozinha/quebra', 'abre'),
(113, 99, 'Controle de Consumo', 60, 'controle_consumo.php', 'modulos/cozinha/controle_consumo', 'abre'),
(115, 99, 'Remessa Unidade', 40, 'remessa.php', 'modulos/cozinha/remessa_unidade', 'abre'),
(116, 99, 'Faturamento', 70, 'faturamento.php', 'modulos/cozinha/faturamento', 'abre'),
(117, 99, 'Necessidades Central', 30, 'necessidade_central.php', 'modulos/cozinha/necessidade_central', 'abre'),
(118, 45, 'Cotação Produto', 0, 'comparacao.php', 'modulos/cozinha/cotacao', 'interno'),
(119, 45, 'Cotação no Fornecedor', 1, 'cotacao.php', 'modulos/cozinha/cotacao', 'interno'),
(120, 115, 'Remessa Unidade', 65, 'envio.php', 'modulos/cozinha/remessa_unidade', 'interno'),
(121, 3, 'Grupos de Produtos', 5, 'grupos.php', 'modulos/estoque/produtos_grupos/', 'abre'),
(122, 0, 'Eleitoral', 120, '', '', 'expande'),
(123, 122, 'Eleitores', 20, 'eleitores.php', 'modulos/eleitoral/eleitores', 'abre'),
(124, 110, 'Novo Pedido', 0, 'novo_pedido.php', 'modulos/estoque/compras/', 'interno'),
(128, 122, 'Pedidos', 50, '', 'modulos/eleitoral/pedidos/', 'expande'),
(132, 128, 'Pedidos', 128, 'pedidos.php', 'modulos/eleitoral/pedidos/', 'abre'),
(133, 122, 'Cadastros', 70, '', 'modulos/eleitoral/cadastros/', 'expande'),
(135, 133, 'Profissoes', 133, 'profissoes.php', 'modulos/eleitoral/cadastros', 'abre'),
(136, 133, 'Zonas', 134, 'zona.php', 'modulos/eleitoral/cadastros', 'abre'),
(137, 133, 'Vinculos', 135, 'vinculos.php', 'modulos/eleitoral/cadastros', 'abre'),
(138, 133, 'Setores', 136, 'setor.php', 'modulos/eleitoral/cadastros', 'abre'),
(139, 133, 'Regioes', 137, 'regioes.php', 'modulos/eleitoral/cadastros', 'abre'),
(140, 133, 'Partidos', 138, 'partidos.php', 'modulos/eleitoral/cadastros', 'abre'),
(141, 122, 'Politico', 30, 'vereador.php', 'modulos/eleitoral/politicos', 'abre'),
(142, 133, 'Coligacoes', 140, 'coligacao.php', 'modulos/eleitoral/cadastros', 'abre'),
(143, 122, 'Colaboradores', 40, 'colaborador.php', 'modulos/eleitoral/colaborador', 'abre'),
(144, 133, 'Grupos Sociais', 124, 'grupo_sociais.php', 'modulos/eleitoral/sociais', 'abre'),
(145, 133, 'Funcoes', 141, 'funcoes.php', 'modulos/eleitoral/cadastros', 'abre'),
(146, 122, 'Relatórios', 90, '', '', 'expande'),
(147, 146, 'Candidato', 1, 'relatorio.php', 'modulos/eleitoral/relatorios/', 'abre'),
(148, 122, 'Resumo', 10, 'index.php', 'modulos/eleitoral/resumo_campanha/', 'abre'),
(149, 133, 'Religioes', 143, 'religioes.php', 'modulos/eleitoral/cadastros', 'abre'),
(151, 122, 'Envio de SMS', 60, '', '', 'expande'),
(155, 151, 'Enviar SMS', 10, 'EleitoralEnviaSMS.php', 'modulos/sysms/views', 'abre'),
(156, 146, 'Bens Imóveis', 0, 'bens.php', 'modulos/eleitoral/relatorios/', 'abre'),
(157, 146, 'Carros', 1, 'bens_carros.php', 'modulos/eleitoral/relatorios/', 'abre'),
(158, 146, 'Lancha', 2, 'bens_lancha.php', 'modulos/eleitoral/relatorios/', 'abre'),
(159, 0, 'Vekttor', 130, '', '', 'expande'),
(160, 159, 'Clientes', 120, 'index.php', 'modulos/vekttor/clientes/', 'abre'),
(161, 146, 'Motos', 50, 'bens_motos.php', 'modulos/eleitoral/relatorios/', 'abre'),
(162, 146, 'Barcos', 90, 'bens_barcos.php', 'modulos/eleitoral/relatorios/', 'abre'),
(164, 8, 'Corretor', 0, 'corretor.php', 'modulos/corretor/corretor', 'abre'),
(165, 1, 'Dono Cliente', 10, 'dono_cliente.php', 'modulos/administrativo/donoCliente', 'abre'),
(166, 38, 'Detalhes do Contrato', 0, 'exibicao_contrato.php', 'modulos/corretor/vendas', 'abre'),
(167, 8, 'Relatórios', 60, '', 'modulos/corretor/relatorios', 'expande'),
(169, 167, 'Vendas Corretor', 10, 'vendas_por_corretor.php', 'modulos/corretor/relatorios/corretor_venda', 'abre'),
(170, 8, 'Contratos', 50, 'contratos.php', 'modulos/corretor/contratos/', 'abre'),
(171, 170, 'Detalhes Contrato', 1, 'detalhes_contrato.php', 'modulos/corretor/contratos/', 'interno'),
(172, 1, 'Negociações Restritas', 120, 'negociacoes_restritas.php', 'modulos/administrativo/negociacoes_restritas/', 'abre'),
(173, 167, 'Cliente Ramo Atividade', 90, 'index.php', 'modulos/corretor/relatorios/cliente_ramo_atividade', 'abre'),
(174, 167, 'Cliente por Bairro', 60, 'index.php', 'modulos/corretor/relatorios/cliente_por_bairro', 'abre'),
(175, 167, 'Cliente por Corretor', 70, 'index.php', 'modulos/corretor/relatorios/cliente_vendedor', 'abre'),
(176, 167, 'Corretor por Imobiliária', 30, 'index.php', 'modulos/corretor/relatorios/corretor_por_imobiliaria', 'abre'),
(177, 167, 'Interesses', 0, 'index.php', 'modulos/corretor/relatorios/interesses', 'abre'),
(178, 167, 'Vendas Imobiliária', 0, 'imobiliaria_venda.php', 'modulos/corretor/relatorios/imobiliaria_venda', 'abre'),
(179, 167, 'Total Venda Imobiliária', 0, 'total_imobiliaria.php', 'modulos/corretor/relatorios/imobiliaria_venda', 'interno'),
(180, 167, 'Total Venda Corretor', 0, 'total_venda.php', 'modulos/corretor/relatorios/corretor_venda', 'interno'),
(181, 159, 'Revenda/Franquia', 0, 'revenda_franquia.php', 'modulos/vekttor/revenda_franquia', 'abre'),
(182, 159, 'Item no Menu', 0, 'item_menu.php', 'modulos/vekttor/item_menu', 'abre'),
(183, 4, 'teste', 0, 'teste.php', 'modulos/tete/teste', 'expande'),
(184, 4, 'teste', 0, 'teste.php', 'modulos/tete/teste', 'expande'),
(191, 3, 'Venda', 40, 'vendas.php', 'modulos/estoque/vendas', 'abre'),
(192, 3, 'Transferencia de Mercadoria', 50, 'transferencia.php', 'modulos/estoque/transferencia', 'abre'),
(193, 192, 'Itens da Transferencia', 0, 'transferencia_item.php', 'modulos/estoque/transferencia', 'abre'),
(194, 42, 'Detalhes Inventário', 1, 'detalhe_inventario.php', 'modulos/estoque/inventarios/detalhe_inventario/', 'interno'),
(195, 3, 'Recebimento de Transferência', 60, 'recebimento_transferencia.php', 'modulos/estoque/transferencia_recebimento', 'abre'),
(196, 195, 'Itens da Transferência', 0, 'recebimento_item.php', 'modulos/estoque/transferencia_recebimento', 'abre'),
(197, 3, 'Recebimento de Compra', 35, 'recebimento.php', 'modulos/estoque/compras_recebimento/', 'abre'),
(198, 197, 'Recebimento', 0, 'compras_recebimento.php', 'modulos/estoque/compras_recebimento/', 'abre'),
(199, 98, 'Colaborador por Periodo', 0, 'colaborador_por_periodo.php', 'modulos/projetos/relatorios', 'abre'),
(200, 3, 'Beneficiamento Recebimento', 80, 'beneficiamento_recebimento.php', 'modulos/estoque/beneficiamento_recebimento', 'abre'),
(201, 191, 'Nova Venda', 0, 'nova_venda.php', 'modulos/estoque/vendas/', 'abre'),
(202, 112, 'Item Contrato', 0, 'item_quebra.php', 'modulos/cozinha/quebra', 'abre'),
(203, 99, 'Necessidade Unidade', 35, 'necessidade_unidade.php', 'modulos/cozinha/necessidade_unidade', 'abre'),
(204, 0, 'Escolar', 50, '', '', 'expande'),
(206, 224, 'Unidades', 10, 'unidades.php', 'modulos/escolar/unidades/', 'abre'),
(208, 224, 'Periodos Letivos', 20, 'periodos.php', 'modulos/escolar/periodos/', 'abre'),
(210, 224, 'Curso', 30, 'cursos.php', 'modulos/escolar/cursos/', 'abre'),
(211, 224, 'Turma', 60, 'salas.php', 'modulos/escolar/salas', 'abre'),
(212, 224, 'Horarios / Turno', 50, 'horarios.php', 'modulos/escolar/horarios/', 'abre'),
(215, 204, 'Alunos', 90, 'index.php', 'modulos/escolar/alunos_inscritos', 'abre'),
(216, 204, 'Exportação', 157, 'exportacao.php', 'modulos/escolar/exportacao/', 'abre'),
(217, 204, 'Matriculas', 70, 'matriculas.php', 'modulos/escolar/matriculas/', 'abre'),
(218, 5, 'Retorno do banco', 158, 'retorno.php', 'modulos/financeiro/retorno_banco/', 'abre'),
(219, 224, 'Bolsistas', 120, 'bolsistas.php', 'modulos/escolar/bolsistas/', 'abre'),
(220, 224, 'Inadimplentes', 130, 'Inadimplentes.php', 'modulos/escolar/Inadimplentes/', 'abre'),
(221, 204, 'Aniversariantes', 160, 'relatorio_aniversariante.php', 'modulos/escolar/relatorios', 'abre'),
(222, 204, 'Responsaveis', 80, 'responsavel.php', 'modulos/escolar/responsavel/', 'abre'),
(223, 221, 'Relatório Sistético', 1, 'relatrorio_sistentico.php', 'modulos/escolar/relatorios/', 'interno'),
(224, 204, 'Cadastro', 155, '', '', 'expande'),
(225, 203, 'Nova Necessidade', 0, 'necessidade_unidade.php', 'modulos/cozinha/necessidade_unidade', 'interno'),
(226, 204, 'Visão Geral', 0, 'relatorio_sintetico.php', 'modulos/escolar/relatorios', 'abre'),
(227, 211, 'Alunos da Sala', 170, 'salas_alunos.php', 'modulos/escolar/salas/', 'interno'),
(228, 204, 'Relatório de Alergias', 180, 'alergia.php', 'modulos/escolar/alergias/', 'abre'),
(229, 228, 'Alunos Com Alergias', 190, 'alunos_alergias.php', 'modulos/escolar/alergias/', 'interno'),
(230, 226, 'Alunos', 1, 'alunos_lista.php', 'modulos/escolar/relatorios', 'interno'),
(232, 224, 'Professor', 62, 'professor.php', 'modulos/escolar/professor', 'abre'),
(234, 224, 'Materia', 35, 'materia.php', 'modulos/escolar/materia', 'abre'),
(243, 242, 'Turmas', 0, 'professor_turma.php', 'modulos/escolar/area_professor/turma', 'interno'),
(244, 204, 'Área do Professor', 100, 'area_professor.php', 'modulos/escolar/area_professor', 'abre'),
(256, 244, 'Lista Avaliação', 0, 'lista_avaliacao.php', 'modulos/escolar/area_professor/avaliacao', 'interno'),
(258, 256, 'Nota Avaliação', 0, 'nota_aluno_avaliacao.php', 'modulos/escolar/area_professor/avaliacao', 'interno'),
(259, 244, 'Lista Aula', 0, 'lista_chamada.php', 'modulos/escolar/area_professor/aula', 'interno'),
(260, 259, 'Chamada', 0, 'chamada_aluno_aula.php', 'modulos/escolar/area_professor/aula', 'interno'),
(261, 224, 'Professor por Turma', 63, 'professor_sala.php', 'modulos/escolar/professor_sala', 'abre'),
(262, 244, 'Média', 0, 'lista_alunos.php', 'modulos/escolar/area_professor/media', 'interno'),
(263, 218, 'Matriculas do Arquivo', 0, 'matriculas.php', 'modulos/financeiro/retorno_banco/', 'interno'),
(264, 224, 'Periodo de Avaliação', 61, 'periodicidade.php', 'modulos/escolar/periodicidade', 'abre'),
(266, 262, 'Média Final', 0, 'media_final.php', 'modulos/escolar/area_professor/media', 'interno'),
(267, 259, 'Faltas', 0, 'falta_materia.php', 'modulos/escolar/area_professor/faltas', 'interno'),
(268, 167, 'Comissão Corretor', 80, 'comissao_corretor.php', 'modulos/corretor/relatorios/comissao_corretor', 'abre'),
(269, 167, 'Comissão Imobiliária', 35, 'comissao_imobiliaria.php', 'modulos/corretor/relatorios/comissao_imobiliaria', 'abre'),
(270, 244, 'Avaliação Recuperação', 0, 'lista_avaliacao_recuperacao.php', 'modulos/escolar/area_professor/avaliacao', 'interno'),
(271, 204, 'Área do Aluno', 105, 'area_aluno.php', 'modulos/escolar/area_aluno', 'expande'),
(272, 244, 'Lista Alunos Recuperação', 0, 'lista_alunos_recuperacao.php', 'modulos/escolar/area_professor/media', 'interno'),
(273, 244, 'Nota Aluno Recuperação', 0, 'nota_aluno_recuperacao.php', 'modulos/escolar/area_professor/avaliacao', 'interno'),
(274, 244, 'Visualizar Nota Recuperação', 0, 'visualizar_notas_recuperacao.php', 'modulos/escolar/area_professor/avaliacao', 'interno'),
(275, 0, 'Ordem Serviço', 18, '', '', 'expande'),
(276, 275, 'O.S Cadastro', 10, 'odem_servico.php', 'modulos/ordem_servico/ordem_servico', 'abre'),
(277, 277, 'Serviços', 0, 'servicos.php', 'modulos/ordem_servico/servicos', 'abre'),
(322, 0, 'Relatório de Notas e Faltas', 200, 'notas_faltas.php', 'modulos/escolar/notas_faltas', 'abre'),
(279, 432, 'Cargos e Salários ', 40, 'cargo_salario.php', 'modulos/rh/cargos_salarios', 'abre'),
(280, 306, 'Produtos Vendidos', 0, 'produtos.php', 'modulos/ordem_servico/relatorios', 'abre'),
(281, 319, 'Visitas', 0, 'visita.php', 'modulos/ordem_servico/agenda_visita', 'abre'),
(282, 285, 'Forum', 0, 'pagina_principal_forum.php', 'modulos/escolar/area_aluno/forum', 'interno'),
(283, 271, ' Notas', 1, 'notas.php', 'modulos/escolar/area_aluno', 'abre'),
(284, 271, 'Faltas', 2, 'faltas.php', 'modulos/escolar/area_aluno/faltas', 'abre'),
(285, 271, 'Aulas', 3, 'materias.php', 'modulos/escolar/area_aluno/aulas/', 'abre'),
(286, 259, 'Upload Arquivo', 0, 'lista_arquivo.php', 'modulos/escolar/area_professor/aula/arquivo', 'interno'),
(287, 285, 'Aulas', 1, 'aulas.php', 'modulos/escolar/area_aluno/aulas/', 'interno'),
(288, 287, 'Aula', 0, 'aula.php', 'modulos/escolar/area_aluno/aulas/', 'interno'),
(289, 288, 'Mensagens Professor', 0, 'mesagem_para_professor.php', 'modulos/escolar/area_aluno/aulas/', 'interno'),
(290, 0, 'Forum', 0, 'pagina_principal_forum.php', 'modulos/escolar/area_aluno/forum', 'interno'),
(291, 244, 'Forum', 0, 'forum_pergunta.php', 'modulos/escolar/area_professor/forum', 'interno'),
(292, 291, 'Todas Perguntas', 0, 'todas_perguntas_forum.php', 'modulos/escolar/area_professor/forum', 'interno'),
(293, 271, 'Tradutor', 25, 'tradutor.php', 'modulos/escolar/area_aluno/tradutor', 'abre'),
(294, 271, 'Mensagens Privadas', 30, 'mensagens_privadas.php', 'modulos/escolar/area_aluno/mensagens', 'abre'),
(296, 291, 'Todas Perguntas', 0, 'todas_perguntas_inicio.php', 'modulos/escolar/area_professor/forum', 'interno'),
(297, 244, 'Mensagens Privadas', 10, 'mensagens.php', 'modulos/escolar/area_professor/mensagens/', 'interno'),
(298, 294, 'Mensagens', 35, 'todas_mensagens.php', 'modulos/escolar/area_aluno/mensagens', 'interno'),
(299, 297, 'Mensagens', 15, 'todas_mensagens.php', 'modulos/escolar/area_professor/mensagens/', 'interno'),
(300, 285, 'Lista Discussões', 0, 'lista_pergunta_aula.php', 'modulos/escolar/area_aluno/forum', 'interno'),
(301, 306, 'Serviços Vendidos', 0, 'servicos_vendidos.php', 'modulos/ordem_servico/relatorios/servicos', 'abre'),
(302, 306, 'Comissão Funcionários', 0, 'comissao_funcionario.php', 'modulos/ordem_servico/relatorios', 'abre'),
(303, 0, 'Aluguel', 14, '', '', 'expande'),
(304, 303, 'Cadastro de Equipamentos', 30, 'equipamento.php', 'modulos/aluguel/equipamento', 'abre'),
(305, 303, 'Locação / Devolução', 10, 'index.php', 'modulos/aluguel/locacao_devolucao', 'abre'),
(306, 275, 'Relatórios', 30, '', '', 'expande'),
(307, 306, 'Receitas X Despesas', 0, 'receitas.php', 'modulos/ordem_servico/relatorios/receitas', 'abre'),
(308, 303, 'Modelo de Contrato', 40, 'contrato.php', 'modulos/aluguel/contrato', 'abre'),
(309, 275, 'Configuração da OS', 19, 'configuracao_os.php', 'modulos/ordem_servico/configuracao', 'abre'),
(310, 204, 'Cobrança', 45, '', '', 'expande'),
(311, 310, 'Gerar Mensalidades', 0, 'mensalidades_escolar.php', 'modulos/cobranca/mensalidades_escolar', 'abre'),
(312, 310, 'Impressão Por aluno', 1, 'impressao_boletos.php', 'modulos/cobranca/mensalidades_escolar/mensalidade_escolar_impressao/', 'abre'),
(314, 303, 'Relatorios', 50, '', '', 'expande'),
(315, 314, 'Disponibilidade Equipamento', 0, 'disponibilidade.php', 'modulos/aluguel/relatorios/disponibilidade', 'abre'),
(316, 310, 'Impressão Massa', 1, 'impressao_boletos_massa.php', 'modulos/cobranca/mensalidades_escolar/mensalidade_escolar_impressao_massa/', 'abre'),
(317, 303, 'Orçamento', 20, 'orcamento.php', 'modulos/aluguel/orcamento', 'abre'),
(318, 314, 'Receitas VS Despesas', 0, 'receitas.php', 'modulos/aluguel/relatorios/receitas', 'abre'),
(319, 275, 'Cadastros', 20, '', '', 'expande'),
(320, 319, 'Serviços', 0, 'servicos.php', 'modulos/ordem_servico/servicos', 'abre'),
(321, 319, 'Atendimento', 0, 'atendimento.php', 'modulos/ordem_servico/atendimento', 'abre'),
(323, 204, 'Relatório de Notas e Faltas', 200, 'notas_faltas.php', 'modulos/escolar/notas_faltas', 'abre'),
(324, 204, 'Aulas Online', 102, 'aulas_online.php', 'modulos/escolar/aulas_online_cadastro/', 'abre'),
(325, 324, 'Aulas do Módulo', 0, 'lista_aulas_modulo.php', 'modulos/escolar/aulas_online_cadastro/aulas_online_cadastradas/', 'interno'),
(326, 325, 'Arquivos da aula', 5, 'arquivos_aula_online.php', 'modulos/escolar/aulas_online_cadastro/aulas_online_cadastradas/arquivos_aula_online/', 'abre'),
(327, 271, 'Aulas Online', 5, 'materias_online.php', 'modulos/escolar/area_aluno/aulas_online/', 'abre'),
(328, 327, 'Aulas da Matéria', 1, 'aula_online_lista.php', 'modulos/escolar/area_aluno/aulas_online/aulas_online_lista/', 'interno'),
(329, 303, 'Configuração do Aluguel', 60, 'configuracao_aluguel.php', 'modulos/aluguel/configuracao', 'abre'),
(330, 328, 'Ver Aula', 5, 'ver_aula_online.php', 'modulos/escolar/area_aluno/aulas_online/ver_aula_online', 'interno'),
(331, 159, 'Serviços', 0, 'servicos.php', 'modulos/vekttor/servicos', 'abre'),
(332, 159, 'Pacotes', 0, 'pacotes.php', 'modulos/vekttor/pacotes', 'abre'),
(333, 159, 'Modelo Contrato Revendedor', 130, 'contrato.php', 'modulos/vekttor/contrato_revendedora', 'abre'),
(334, 159, 'Modelo Contrato Cliente', 140, 'contrato.php', 'modulos/vekttor/contrato_cliente', 'abre'),
(335, 159, 'Relatórios', 150, '', '', 'expande'),
(337, 335, 'Analise de Revendedor', 0, 'analise_revendedor.php', 'modulos/vekttor/relatorios', 'abre'),
(338, 335, 'Analise de Mensalidades', 1, 'analise_mensalidades.php', 'modulos/vekttor/relatorios', 'abre'),
(357, 159, 'Tutorial', 160, '', '', 'expande'),
(358, 357, 'Ajuda', 0, 'index.php', 'modulos/vekttor/tutorial', 'abre'),
(341, 335, 'Rank Vendedores', 2, 'rank_vendedores.php', 'modulos/vekttor/relatorios', 'abre'),
(342, 335, 'Venda de pacote', 3, 'venda_pacotes.php', 'modulos/vekttor/relatorios', 'abre'),
(343, 0, 'Revenda Vekttor', 140, '', '', 'expande'),
(344, 343, 'Vendedor', 0, 'vendedor.php', 'modulos/revenda_vekttor/vendedor', 'abre'),
(345, 343, 'Configuração', 0, 'configuracao.php', 'modulos/revenda_vekttor/configuracao', 'abre'),
(346, 343, 'Contato', 0, 'contato.php', 'modulos/revenda_vekttor/contato', 'abre'),
(348, 343, 'Relatórios', 50, '', '', 'expande'),
(349, 348, 'Venda por vendedor', 1, 'venda_vendedor.php', 'modulos/revenda_vekttor/relatorios', 'abre'),
(350, 348, 'Vendedor por Atendimento', 2, 'vendedor_atendimento.php', 'modulos/revenda_vekttor/relatorios', 'abre'),
(351, 348, 'Vendedor por Fechamento', 3, 'vendedor_fechamento.php', 'modulos/revenda_vekttor/relatorios', 'abre'),
(352, 343, 'Atendimento de Vendedor', 40, 'atendimento_vendedor.php', 'modulos/revenda_vekttor/atendimento_vendedor', 'abre'),
(353, 159, 'Revenda', 0, 'revenda.php', 'modulos/revenda_vekttor/revenda', 'abre'),
(354, 343, 'Venda', 0, 'venda.php', 'modulos/revenda_vekttor/venda', 'abre'),
(355, 348, 'Venda por Período', 4, 'venda_periodo.php', 'modulos/revenda_vekttor/relatorios', 'abre'),
(356, 341, 'Vendas', 1, 'venda_vendedores.php', 'modulos/vekttor/relatorios', 'interno'),
(359, 349, 'Venda por Vendedor Analitico', 0, 'venda_vendedor_analitico.php', 'modulos/revenda_vekttor/relatorios', 'abre'),
(360, 350, 'Vendedor por Atendimento Analitico', 0, 'vendedor_atendimento_analitico.php', 'modulos/revenda_vekttor/relatorios', 'abre'),
(361, 351, 'Vendedor Por Fechamento Analítico', 0, 'vendedor_fechamento_analitico.php', 'modulos/revenda_vekttor/relatorios', 'abre'),
(362, 355, 'Venda por Periodo Analitico', 0, 'venda_periodo_analitico', 'modulos/revenda_vekttor/relatorios', 'abre'),
(363, 146, 'Eleitores', 0, 'eleitores_index.php', 'modulos/eleitoral/relatorios', 'abre'),
(408, 410, 'Cadastro de Promocao', 45, 'promocao.php', 'modulos/eleitoral/promocao', 'abre'),
(365, 337, 'Analise Revendedor Analítico', 0, 'analise_revendedor_analitico.php', 'modulos/vekttor/relatorios', 'abre'),
(366, 338, 'Analise de Mensalidades Analítico', 0, 'analise_mensalidade_analitico.php', 'modulos/vekttor/relatorios', 'abre'),
(367, 0, 'Agendamendo', 0, '', '', 'expande'),
(368, 0, 'Odonto', 0, '', '', 'expande'),
(369, 0, 'E-mail Marketing', 0, '', '', 'expande'),
(370, 0, 'SMS', 0, '', '', 'expande'),
(371, 380, 'Convenio', 10, 'convenio.php', 'modulos/odonto/convenios', 'abre'),
(372, 367, 'Agenda Diaria', 0, 'agendadiaria.php', 'modulos/agendamento/agenda_diaria/', 'abre'),
(373, 380, 'Procedimentos', 20, 'servicos.php', 'modulos/ordem_servico/servicos', 'abre'),
(374, 380, 'Modelos  de Contrato', 30, 'modelo_contrato.php', 'modulos/odonto/modelo_contrato', 'abre'),
(376, 369, 'E-Mail Marketing', 10, 'emailmarketing.php', 'modulos/emailmarketing/emailmarketing', 'abre'),
(398, 407, 'SMS Importados', 45, 'sms_importado.php', 'modulos/eleitoral/sms_importado/', 'abre'),
(380, 368, 'Cadastros', 40, '', '', 'expande'),
(382, 368, 'Odontologo', 40, 'odontologo.php', 'modulos/odonto/odontologo', 'abre'),
(383, 368, 'Fila de Espera', 50, 'fila_de_espera.php', 'modulos/odonto/fila_espera', 'abre'),
(389, 368, 'Relatórios', 60, '', '', 'expande'),
(386, 370, 'Enviar SMS', 0, 'odontosms.php', 'modulos/sms/odonto', 'abre'),
(387, 368, 'Atendimento', 10, 'atendimento.php', 'modulos/odonto/atendimento/', 'abre'),
(388, 368, 'Aprovação e Pagamento', 15, 'pagamento.php', 'modulos/odonto/pagamento', 'abre'),
(390, 389, 'Atendimento por Odontólogo', 1, 'atendimento_odontologo.php', 'modulos/odonto/relatorios', 'abre'),
(391, 389, 'Última Consulta Cliente', 2, 'ultima_consulta_cliente.php', 'modulos/odonto/relatorios', 'abre'),
(392, 306, 'Atividades Por Colaborador', 50, 'atividade_colaborador.php', 'modulos/ordem_servico/relatorios', 'abre'),
(393, 314, 'Entregas Atrasadas', 30, 'entregas_atrasadas.php', 'modulos/aluguel/relatorios/entregas_atrasadas', 'abre'),
(394, 389, 'Cliente X Serviço X Tempo', 3, 'cliente_servicos_tempo.php', 'modulos/odonto/relatorios/cliente_servico_tempo', 'abre'),
(395, 394, 'Cliente x Tempo', 10, 'cliente_tempo.php', 'modulos/odonto/relatorios/cliente_servico_tempo', 'interno'),
(396, 3, 'Relatorios', 100, '', '', 'expande'),
(397, 396, 'Histórico de Produto', 0, 'historico_produto.php', 'modulos/estoque/relatorios', 'abre'),
(399, 204, 'Todas Aulas', 0, 'aulas.php', 'modulos/escolar/aulas', 'abre'),
(400, 407, 'Importação Facebook', 47, 'importacao_facebook.php', 'modulos/eleitoral/importacao_facebook', 'abre'),
(401, 122, 'Importação Rádio', 48, 'importacao_radio.php', 'modulos/eleitoral/importacao_radio', 'abre'),
(402, 122, 'E-mail Marketing', 55, 'emailmarketing.php', 'modulos/eleitoral/emailmarketing', 'abre'),
(403, 224, 'Alunos Reprovados', 85, 'reprovados.php', 'modulos/escolar/alunos_reprovados/', 'abre'),
(404, 271, 'Financeiro', 0, 'financeiro.php', 'modulos/escolar/area_aluno/financeiro', 'abre'),
(405, 146, 'Aniversariante', 0, 'aniversariante.php', 'modulos/eleitoral/aniversariante', 'abre'),
(406, 407, 'Importação E-mail', 49, 'importacao_email.php', 'modulos/eleitoral/importacao_email', 'abre'),
(407, 122, 'Importação', 100, '', '', 'expande'),
(409, 410, 'Participante Promoção', 46, 'participante_promocao.php', 'modulos/eleitoral/participante_promocao', 'abre'),
(410, 122, 'Promoção', 110, 'promocao.php', '', 'expande'),
(411, 402, 'Emails Enviados', 1, 'emails_enviados.php', 'modulos/eleitoral/emailmarketing/', 'interno'),
(412, 402, 'Emails Recebidos', 2, 'emails_recebidos.php', 'modulos/eleitoral/emailmarketing/', 'interno'),
(413, 402, 'Não Enviados', 3, 'emails_naoenviados.php', 'modulos/eleitoral/emailmarketing/', 'interno'),
(414, 376, 'Emails Enviados', 1, 'emails_enviados.php', 'modulos/emailmarketing/emailmarketing/', 'interno'),
(415, 376, 'Recebidos ', 2, 'emails_recebidos.php', 'modulos/emailmarketing/emailmarketing/', 'interno'),
(416, 376, 'Emails Não Recebidos', 3, 'emails_naoenviados.php', 'modulos/emailmarketing/emailmarketing/', 'interno'),
(417, 93, 'Empresa', 10, 'empresa.php', 'modulos/rh/empresa/', 'abre'),
(418, 93, 'Movimentacao', 20, '', '', 'expande'),
(419, 418, 'Admissão de Funcionário', 0, 'funcionarios.php', 'modulos/rh/funcionarios', 'abre'),
(420, 419, 'Funcionario', 1, 'lista_funcionario.php', 'modulos/rh/funcionarios', 'interno'),
(421, 93, 'Modelos de Contrato', 50, 'modelo_contrato.php', 'modulos/odonto/modelo_contrato/', 'abre'),
(422, 418, 'Alteração de Salário', 1, 'alteracao_salario.php', 'modulos/rh/alteracao_salario/', 'abre'),
(423, 422, 'Alteração Salário Funcionário', 1, 'alteracao_salario_funcionario.php', 'modulos/rh/alteracao_salario/', 'interno'),
(424, 418, 'Mudança de Cargo', 2, 'mudanca_cargo.php', 'modulos/rh/mudanca_cargo/', 'abre'),
(425, 424, 'Mudança Cargo Funcionario', 1, 'mudanca_cargo_funcionario.php', 'modulos/rh/mudanca_cargo/', 'interno'),
(426, 418, 'Demissão de Funcionário', 3, 'demissao_funcionario.php', 'modulos/rh/demissao_funcionario/', 'abre'),
(427, 426, 'Demissão', 1, 'demissao.php', 'modulos/rh/demissao_funcionario/', 'interno'),
(428, 93, 'Cobrança', 30, '', '', 'expande'),
(429, 428, 'Cobrança', 1, 'cobranca.php', 'modulos/rh/cobranca', 'abre'),
(430, 428, 'Relatório', 2, 'relatorio.php', 'modulos/rh/cobranca', 'abre'),
(431, 430, 'Relatório de Cobranças', 1, 'relatorio_interno.php', 'modulos/rh/cobranca/', 'interno'),
(432, 93, 'Tabelas', 35, '', '', 'expande'),
(433, 432, 'INSS', 1, 'inss.php', 'modulos/rh/tabelas/inss', 'abre'),
(434, 432, 'Salario Familia', 0, 'salario_familia.php', 'modulos/rh/tabelas/salario_familia', 'abre'),
(435, 432, 'IRPF', 3, 'irpf.php', 'modulos/rh/tabelas/irpf', 'abre'),
(436, 418, 'Férias', 36, 'ferias.php', 'modulos/rh/ferias/', 'abre'),
(437, 204, 'Resumo de Matriculas', 1000, 'matriculas.php', 'modulos/escolar/relatorios', 'blank'),
(438, 204, 'Ultimas Matriculas', 2000, 'ultimas_matriculas.php', 'modulos/escolar/relatorios', 'blank'),
(439, 93, 'Folha de Pagamento', 60, 'folha_pagamento.php', 'modulos/rh/folha_pagamento', 'abre'),
(440, 93, 'Hora Extra', 36, 'hora_extra.php', 'modulos/rh/hora_extra/', 'abre'),
(441, 439, 'Gerenciar Folha de Pagamento', 5, 'administracao_folha_pagamento.php', 'modulos/rh/folha_pagamento/', 'interno'),
(442, 440, 'Hora Extra Funcionário', 1, 'hora_extra_funcionario.php', 'modulos/rh/hora_extra/', 'interno'),
(443, 418, 'Relatório de Movimentações', 60, 'relatorio_movimentacoes.php', 'modulos/rh/relatorios/', 'abre'),
(444, 432, 'Feriados', 0, 'feriado.php', 'modulos/rh/tabelas/feriados', 'abre'),
(445, 93, 'Alterar Folha de Pagamento', 70, 'folha_pagamento.php', 'modulos/rh/folha_pagamento/', 'abre'),
(446, 445, 'Alteração de Folha', 5, 'administracao_folha_pagamento.php', 'modulos/rh/folha_pagamento/', 'interno'),
(447, 0, 'Backup', 900, 'backup_prototipo.php', 'modulos/backup', 'expande'),
(449, 447, 'Backup Completo', 10, 'backup_prototipo.php', 'modulos/backup/', 'abre'),
(450, 93, 'CAGED', 80, 'caged.php', 'modulos/rh/caged', 'abre'),
(452, 275, 'Impressoes OS', 11, 'impressao_os.php', 'modulos/ordem_servico/impressao_os/', 'abre'),
(453, 122, 'Definir Sexo', 0, 'definir_sexo.php', 'modulos/eleitoral/definir_sexo', 'abre'),
(454, 0, 'Escolar2', 0, '', '', 'expande'),
(455, 454, 'Cadastro', 0, '', '', 'expande'),
(456, 455, 'Estrutura Curricular', 10, 'cursos.php', 'modulos/escolar2/cursos/', 'abre'),
(457, 455, 'Funcionários', 20, 'funcionarios.php', 'modulos/escolar2/cadastros/funcionarios/', 'abre'),
(458, 455, 'Escolas', 30, 'escolas.php', 'modulos/escolar2/escolas/', 'abre'),
(459, 455, 'Calendário Escolar', 40, 'agendadiaria.php', 'modulos/agendamento/agenda_diaria/', 'abre'),
(460, 455, 'Vagas por Ano', 50, 'vagas.php', 'modulos/escolar2/vagas/', 'abre'),
(461, 454, 'Matriculas', 20, '', '', 'expande'),
(462, 461, 'Confirmação de Matriculas', 10, 'matricula_confirmacao.php', 'modulos/escolare/matricula_confirmacao/', 'abre'),
(463, 455, 'Ensino', 5, 'ensino.php', 'modulos/escolar2/ensino', 'abre'),
(464, 455, 'Séries', 6, 'serie.php', 'modulos/escolar2/serie', 'abre'),
(465, 455, 'Salas', 31, 'salas.php', 'modulos/escolar2/salas', 'abre'),
(467, 455, 'Cargos', 10, 'cargos.php', 'modulos/escolar2/cadastros/cargos', 'abre'),
(469, 455, 'Professores', 90, 'professores.php', 'modulos/escolar2/cadastros/professores', 'abre');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
