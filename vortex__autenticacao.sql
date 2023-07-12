-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Jul-2023 às 14:44
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `vortex__autenticacao`
--

DELIMITER $$
--
-- Funções
--
CREATE DEFINER=`vegacsco_001`@`%` FUNCTION `somentenumero` (`PALAVRA` VARCHAR(255)) RETURNS VARCHAR(255) CHARSET latin1 BEGIN
  DECLARE RESULTADO varchar(255);
  DECLARE LETRA varchar(1);
  DECLARE QTD_PALAVRA integer;
  DECLARE CONT integer;

  SET CONT = 0;
  SET QTD_PALAVRA = LENGTH(PALAVRA);
  SET RESULTADO = '';
  WHILE (CONT < QTD_PALAVRA) DO
  BEGIN
    SET CONT = CONT + 1;
    SET LETRA = SUBSTRING(PALAVRA, CONT, 1);
    IF LETRA IN ('0', '1', '2', '3', '4', '5', '6', '7', '8', '9') THEN
    BEGIN
      SET RESULTADO = CONCAT(RESULTADO, LETRA);
    END;
    END IF;
  END;
  END WHILE;
  RETURN RESULTADO;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sisempresas`
--

CREATE TABLE `sisempresas` (
  `emp_codigo` int(1) UNSIGNED NOT NULL,
  `emp_ativado` set('s','n') DEFAULT 'n',
  `emp_nome` varchar(255) NOT NULL DEFAULT '',
  `emp_bd` varchar(255) NOT NULL COMMENT 'Nome do banco de dados para fazer conexão ao logar no sistema',
  `emp_bd_host` text NOT NULL,
  `emp_bd_user` varchar(100) NOT NULL,
  `emp_bd_pass` varchar(255) NOT NULL,
  `emp_email` varchar(150) NOT NULL DEFAULT '',
  `emp_telefone` varchar(50) NOT NULL DEFAULT '',
  `emp_cidade` varchar(255) NOT NULL,
  `emp_estado` varchar(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sisempresas`
--

INSERT INTO `sisempresas` (`emp_codigo`, `emp_ativado`, `emp_nome`, `emp_bd`, `emp_bd_host`, `emp_bd_user`, `emp_bd_pass`, `emp_email`, `emp_telefone`, `emp_cidade`, `emp_estado`) VALUES
(1, 's', 'Nostra Casa', 'vortex_nostracasa', 'localhost', 'root', '', 'contato@nostracasa.com.br', '(49) 3322-8466', 'Chapecó', 'SC'),
(2, 's', 'Santa Maria', 'vortex_santamaria', 'locahost', 'root', '', 'contato@santamaria.com.br', '(49) 3322-3387', 'Chapecó', 'SC');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sismenu`
--

CREATE TABLE `sismenu` (
  `men_codigo` int(11) NOT NULL,
  `men_nome` text NOT NULL COMMENT 'Nome que irá aparecer no Menu para o usuário.',
  `men_url` text DEFAULT NULL COMMENT 'Sem URL é um menu com filhos, com URL é só passar o link de acesso interno do sistema',
  `men_icone` text DEFAULT NULL COMMENT 'icone somente para os menus principais ( sem url e sem pai)',
  `men_pai` int(11) DEFAULT NULL COMMENT 'codigo do menu pai.',
  `pro_nome` text NOT NULL COMMENT 'Nome do programa, no sistema principal (sisprograma)',
  `men_situacao` int(11) NOT NULL DEFAULT 1,
  `men_target` text DEFAULT NULL COMMENT 'Caso precise enviar como _seft ou _blank',
  `men_flag` text DEFAULT NULL COMMENT 'Deve ser usado no caso de termos algo para sinalizar, como Novo, Atenção e etc.',
  `men_ordem` int(11) NOT NULL DEFAULT 0,
  `men_nivel` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sismenu`
--

INSERT INTO `sismenu` (`men_codigo`, `men_nome`, `men_url`, `men_icone`, `men_pai`, `pro_nome`, `men_situacao`, `men_target`, `men_flag`, `men_ordem`, `men_nivel`) VALUES
(1, 'Sistema', NULL, 'application/icons/sistema.svg', NULL, '', 1, NULL, NULL, 0, 0),
(2, 'Empresas', '?module=sistema&acao=lista_empresa', NULL, 1, 'sisEmpresas', 1, NULL, NULL, 0, 1),
(3, 'Programas', '?module=sistema&acao=lista_programa', NULL, 1, 'sisProgramas', 1, NULL, NULL, 0, 1),
(4, 'Pemissões de Acesso', '?module=sistema&acao=lista_permissao', NULL, 1, 'sisPermissoes', 1, NULL, NULL, 0, 1),
(5, 'Usuários', '?module=sistema&acao=lista_usuario', NULL, 1, 'sisUsuarios', 1, NULL, NULL, 0, 1),
(6, 'Cadastros', NULL, 'application/icons/cadastro.svg', NULL, '', 1, NULL, NULL, 0, 0),
(7, 'Pessoas', '?module=cadastro&acao=lista_pessoa', NULL, 6, 'cadPessoas', 1, NULL, NULL, 0, 1),
(8, 'Profissões', '?module=cadastro&acao=lista_profissao', NULL, 6, 'cadProfissoes', 1, NULL, NULL, 0, 1),
(9, 'Cidades', '?module=cadastro&acao=lista_cidade', NULL, 6, 'cadCidades', 1, NULL, NULL, 0, 1),
(10, 'Paises', '?module=cadastro&acao=lista_pais', NULL, 6, 'cadPaises', 1, NULL, NULL, 0, 1),
(11, 'Bairros', '?module=cadastro&acao=lista_bairro', NULL, 6, 'cadBairros', 1, NULL, NULL, 0, 1),
(12, 'Corretores', '?module=cadastro&acao=lista_corretor', NULL, 6, 'cadCorretores', 1, NULL, NULL, 0, 1),
(13, 'Empreendimentos', '?module=cadastro&acao=lista_empreendimento', NULL, 6, 'cadEmpreendimentos', 1, NULL, NULL, 0, 1),
(14, 'Condomínios', '?module=cadastro&acao=lista_condominio', NULL, 6, 'cadCondominios', 1, NULL, NULL, 0, 1),
(15, 'Tipos de Piso', '?module=cadastro&acao=lista_tipopiso', NULL, 6, 'cadTipoPiso', 1, NULL, NULL, 0, 1),
(16, 'Tipos de Forro', '?module=cadastro&acao=lista_tipoforro', NULL, 6, 'cadTipoForro', 1, NULL, NULL, 0, 1),
(17, 'Origem Atendimento', '?module=cadastro&acao=lista_origatendimento', NULL, 6, 'cadOrigemAtendimento', 1, NULL, NULL, 0, 1),
(18, 'Motivo Conclusão do Atendimento', '?module=cadastro&acao=lista_moticlsatend', NULL, 6, 'cadMotivoConclusaoAtendimento', 1, NULL, NULL, 0, 1),
(19, 'Tipos de Imóvel', '?module=cadastro&acao=lista_tipoimovel', NULL, 6, 'cadTipoImovel', 1, NULL, NULL, 0, 1),
(20, 'Locação', NULL, NULL, 6, '', 1, NULL, NULL, 0, 1),
(21, 'Categorias de Locação', '?module=cadastro&acao=lista_loccategoria', NULL, 20, 'cadLocacaoCategorias', 1, NULL, NULL, 0, 2),
(22, 'Indicadores de Reajuste', '?module=cadastro&acao=lista_locindreajuste', NULL, 20, 'cadIndicadoresReajuste', 1, NULL, NULL, 0, 2),
(23, 'Motivos de Saída', '?module=cadastro&acao=lista_locmotsaida', NULL, 20, 'cadLocacaoMotivoSaida', 1, NULL, NULL, 0, 2),
(24, 'Tabela I.R.R.F', '?module=cadastro&acao=lista_locimprendafonte', NULL, 20, 'CadImpostoRendaFonte', 1, NULL, NULL, 0, 2),
(25, 'Financeiro', NULL, NULL, 6, '', 1, NULL, NULL, 0, 1),
(26, 'Bancos', '?module=cadastro&acao=lista_finbanco', NULL, 25, 'CadBancos', 1, NULL, NULL, 0, 2),
(27, 'Contas', '?module=cadastro&acao=lista_finconta', NULL, 25, 'cadContasBancarias', 1, NULL, NULL, 0, 2),
(28, 'Planos de Conta', '?module=cadastro&acao=lista_finplanconta', NULL, 25, 'cadPlanoContas', 1, NULL, NULL, 0, 2),
(29, 'Categorias Financeiro', '?module=cadastro&acao=lista_fincategoria', NULL, 25, 'cadFinanceiroCategorias', 1, NULL, NULL, 0, 2),
(30, 'Moedas', '?module=cadastro&acao=lista_finmoedas', NULL, 25, 'cadMoedas', 1, NULL, NULL, 0, 2),
(31, 'Vendas', NULL, 'application/icons/venda.svg', NULL, '', 1, NULL, NULL, 0, 0),
(32, 'Gerenciar Imóveis', '?module=venda&acao=lista_imovel', NULL, 31, 'venImoveis', 1, NULL, NULL, 0, 1),
(33, 'Atender Pretendente', '?module=venda&acao=lista_pretendente', NULL, 31, 'venAtendimento', 1, NULL, NULL, 0, 1),
(34, 'Agendar Visitas', '?module=venda&acao=lista_visita', NULL, 31, 'venVisitas', 1, NULL, NULL, 0, 1),
(35, 'Fechamentos', '?module=venda&acao=lista_fechamento', NULL, 31, 'venFechamento', 1, NULL, NULL, 0, 1),
(36, 'Fechamentos Loteadora', '?module=venda&acao=lista_fechaloteadora', NULL, 31, 'venFechamentoLoteadora', 1, NULL, NULL, 0, 1),
(37, 'Modelos de Documentos', '?module=venda&acao=lista_moddocumento', NULL, 31, 'venModelos', 1, NULL, NULL, 0, 1),
(38, 'Anúncios', '?module=venda&acao=lista_anuncio', NULL, 31, 'venAnuncios', 1, NULL, NULL, 0, 1),
(39, 'DIMOB', '?module=venda&acao=lista_dimob', NULL, 31, 'venArquivoDIMOB', 1, NULL, NULL, 0, 1),
(40, 'Movimentação Financeiro', NULL, NULL, 31, '', 1, NULL, NULL, 0, 1),
(41, 'Remessa Titulos para o Banco', '?module=venda&acao=lista_remessatitbanco', NULL, 40, 'venMovimentacaoFinanceira', 1, NULL, NULL, 0, 2),
(42, 'Retorno Titulos do Banco', '?module=venda&acao=lista_retornotitbanco', NULL, 40, 'venMovimentacaoFinanceira', 1, NULL, NULL, 0, 2),
(43, 'Locação', NULL, 'application/icons/locacao.svg', NULL, '', 1, NULL, NULL, 0, 0),
(44, 'Gerenciar Imóveis', '?module=locacao&acao=lista_imoveis', NULL, 43, 'locImoveis', 1, NULL, NULL, 0, 1),
(45, 'Atender Pretendentes', '?module=locacao&acao=lista_pretendente', NULL, 43, 'locAtendimento', 1, NULL, NULL, 0, 1),
(46, 'Visitas Agendadas', '?module=locacao&acao=lista_visita', NULL, 43, 'locVisitas', 1, NULL, NULL, 0, 1),
(47, 'Contratos', '?module=locacao&acao=lista_contrato', NULL, 43, 'locContratos', 1, NULL, NULL, 0, 1),
(48, 'Manutenção Nova', '?module=locacao&acao=lista_manunova', NULL, 43, 'locManutencaoN', 1, NULL, NULL, 0, 1),
(49, 'Manutenção', '?module=locacao&acao=lista_manutencao', NULL, 43, 'locManutencao', 1, NULL, NULL, 0, 1),
(50, 'Movimentação Financeira', NULL, NULL, 43, '', 1, NULL, NULL, 0, 1),
(51, 'Lançamentos', '?module=locacao&acao=lista_finlancamento', NULL, 50, 'locMovimentacaoFinanceira', 1, NULL, NULL, 0, 2),
(52, 'Recibos e Cheques', '?module=locacao&acao=lista_finreciboscheques', NULL, 50, 'LocMovimentacaoFinanceiraProprietario', 1, NULL, NULL, 0, 2),
(53, 'Geração de arquivo', '?module=locacao&acao=lista_fingeraquivo', NULL, 50, 'locMovimentacaoArquivos', 1, NULL, NULL, 0, 2),
(54, 'Retorno de Arquivo', '?module=locacao&acao=lista_finretaquivo', NULL, 50, 'locMovimentacaoRetorno', 1, NULL, NULL, 0, 2),
(55, 'Receber Aluguel', '?module=locacao&acao=lista_finrecaluguel', NULL, 50, 'locReceberAluguel', 1, NULL, NULL, 0, 2),
(56, 'Repassar Aluguel', '?module=locacao&acao=lista_finrepaluguel', NULL, 50, 'locRepassarAluguel', 1, NULL, NULL, 0, 2),
(57, 'Repassar Aluguel Interno', '?module=locacao&acao=lista_finrepaluguelint', NULL, 50, 'locRepassarAluguelInterno', 1, NULL, NULL, 0, 2),
(58, 'DIMOB', '?module=locacao&acao=lista_findimob', NULL, 50, 'locArquivoDIMOB', 1, NULL, NULL, 0, 2),
(59, 'Modelos de Documentos', '?module=locacao&acao=lista_moddocumento', NULL, 43, 'locModelos', 1, NULL, NULL, 0, 1),
(60, 'Financeiro', NULL, 'application/icons/financeiro.svg', NULL, '', 1, NULL, NULL, 0, 0),
(61, 'Contas a Receber', '?module=financeiro&acao=lista_receber', NULL, 60, 'finReceber', 1, NULL, NULL, 0, 1),
(62, 'Contas a Pagar', '?module=financeiro&acao=lista_pagar', NULL, 60, 'finPagar', 1, NULL, NULL, 0, 1),
(63, 'Caixa', '?module=financeiro&acao=lista_caixa', NULL, 60, 'finCaixa', 1, NULL, NULL, 0, 1),
(64, 'Movimento', '?module=financeiro&acao=lista_movimento', NULL, 60, 'finMovimento', 1, NULL, NULL, 0, 1),
(65, 'Documentos', NULL, NULL, 60, '', 1, NULL, NULL, 0, 1),
(66, 'Impressão de Recibos', '?module=financeiro&acao=lista_docrecibo', NULL, 65, 'finRecibo', 1, NULL, NULL, 0, 2),
(67, 'Geração de Nota Promissória', '?module=financeiro&acao=lista_docpromissoria', NULL, 65, 'finPromissoria', 1, NULL, NULL, 0, 2),
(68, 'Cheques', '?module=financeiro&acao=lista_doccheque', NULL, 65, 'finChequeAvulso', 1, NULL, NULL, 0, 2),
(69, 'Modelo de Documentos', '?module=financeiro&acao=lista_moddocumento', NULL, 60, 'finModelos', 1, NULL, NULL, 0, 2),
(70, 'Vendas do Período (Construtoras)', '?module=financeiro&acao=lista_vendacontrutora', NULL, 60, 'finReceberComissaoConstrutora', 1, NULL, NULL, 0, 2),
(71, 'Relatórios', NULL, 'application/icons/relatorio.svg', NULL, '', 1, NULL, NULL, 0, 0),
(72, 'Agenda', '?module=relatorio&acao=lista_agenda', NULL, 71, 'relAgenda', 1, NULL, NULL, 0, 1),
(73, 'Pessoas', '?module=relatorio&acao=lista_pessoas', NULL, 71, 'relPessoas', 1, NULL, NULL, 0, 1),
(74, 'Vendas', NULL, NULL, 71, '', 1, NULL, NULL, 0, 1),
(75, 'Relação de Imóveis', '?module=relatorio&acao=lista_venimovel', NULL, 74, 'relVendasImoveisRelacao', 1, NULL, NULL, 0, 2),
(76, 'Composição dos Imóveis', '?module=relatorio&acao=lista_vencompimovel', NULL, 74, 'relVendasImoveisComposicao', 1, NULL, NULL, 0, 2),
(77, 'Imóveis agenciados', '?module=relatorio&acao=lista_venimoagenciado', NULL, 74, 'relVendasImoveisAgenciados', 1, NULL, NULL, 0, 2),
(78, 'Imóveis Agenciados por Validade', '?module=relatorio&acao=lista_venimoageval', NULL, 74, 'relVendasImoveisAgenciadosValidade', 1, NULL, NULL, 0, 2),
(79, 'Imóveis Suspensos', '?module=relatorio&acao=lista_venimosuspenso', NULL, 74, 'relVendasImoveisSuspensos', 1, NULL, NULL, 0, 2),
(80, 'Imóveis Reservados', '?module=relatorio&acao=lista_venimoreservado', NULL, 74, 'relVendasImoveisReservados', 1, NULL, NULL, 0, 2),
(81, 'Imóveis - Lista de Preços', '?module=relatorio&acao=lista_venimopreco', NULL, 74, 'relVendasImoveisPrecos', 1, NULL, NULL, 0, 2),
(82, 'Imóveis Solicitados via WEB', '?module=relatorio&acao=lista_venimosolweb', NULL, 74, 'relVendasImoveisWeb', 1, NULL, NULL, 0, 2),
(83, 'Atendimento Pretendentes', '?module=relatorio&acao=lista_venatendpretend', NULL, 74, 'relVendasAtendimentos', 1, NULL, NULL, 0, 2),
(84, 'Pretendentes de Imóveis', '?module=relatorio&acao=lista_venpretendimo', NULL, 74, 'relVendasPretendentes', 1, NULL, NULL, 0, 2),
(85, 'Produtividade da Empresa', '?module=relatorio&acao=lista_venprodutividade', NULL, 74, 'relVendasProdutividade', 1, NULL, NULL, 0, 2),
(86, 'Produtividade dos Corretores', '?module=relatorio&acao=lista_venprodutcorretor', NULL, 74, 'relVendasProdutividadeCorretor', 1, NULL, NULL, 0, 2),
(87, 'Participação de Corretores e Agenciadores', '?module=relatorio&acao=lista_venparticipacao', NULL, 74, 'relVendasParticipacao', 1, NULL, NULL, 0, 2),
(88, 'Resumo de Vendas por Tipo de Imóvel', '?module=relatorio&acao=lista_venrestpimovel', NULL, 74, 'relVendasFechamentoResumo', 1, NULL, NULL, 0, 2),
(89, 'Relação de Compradores e Vendedores', '?module=relatorio&acao=lista_venrelcompvende', NULL, 74, 'relVendasCompradoresVendedores', 1, NULL, NULL, 0, 2),
(90, 'Honorários Empresa e Corretores', '?module=relatorio&acao=lista_venhonorario', NULL, 74, 'relVendasEmpresaCorretor', 1, NULL, NULL, 0, 2),
(91, 'Analise Valor/Tempo', '?module=relatorio&acao=lista_venvalortempo', NULL, 74, 'relVendasAnaliseTempo', 1, NULL, NULL, 0, 2),
(92, 'Produtividade - Participação Empresa', '?module=relatorio&acao=lista_venpartempresa', NULL, 74, 'relVendasEmpresaParticipacao', 1, NULL, NULL, 0, 2),
(93, 'Financiamento por Modalidade', '?module=relatorio&acao=lista_venfinmodalidade', NULL, 74, 'relVendasFinanciamentoModalidades', 1, NULL, NULL, 0, 2),
(94, 'Locação', NULL, NULL, 71, '', 1, NULL, NULL, 0, 1),
(95, 'Locação (Atendimento)', NULL, NULL, 71, '', 1, NULL, NULL, 0, 1),
(96, 'Imóveis Agenciados / 1º Agenciamento', '?module=relatorio&acao=lista_locatendimoagenciadopri', NULL, 95, 'relLocacaoImoveisAgenciados', 1, NULL, NULL, 0, 2),
(97, 'Imóveis Agenciados / Renovados', '?module=relatorio&acao=lista_locatendimorenovado', NULL, 95, 'relLocacaoImoveisAgenciadosRenovados', 1, NULL, NULL, 0, 2),
(98, 'Imóveis Solicitação via WEB', '?module=relatorio&acao=lista_locatendimoweb', NULL, 95, 'relLocacaoImoveisWeb', 1, NULL, NULL, 0, 2),
(99, 'Pretendentes de Imóveis', '?module=relatorio&acao=lista_locatendimoweb', NULL, 95, 'relLocacaoPretendentes', 1, NULL, NULL, 0, 2),
(100, 'Imóveis Reservados', '?module=relatorio&acao=lista_locatendimoreservados', NULL, 95, 'relLocacaoImoveisReservados', 1, NULL, NULL, 0, 2),
(101, 'Resumo Imóveis Agenciados / Locados', '?module=relatorio&acao=lista_locatendimoresumo', NULL, 95, 'relLocacaoImoveisAgenciadosResumo', 1, NULL, NULL, 0, 2),
(102, 'Imóveis Agenciados / Renovados', '?module=relatorio&acao=lista_locatendimoagenciadoloc', NULL, 95, 'relLocacaoImoveisAgenciadosRenovados', 1, NULL, NULL, 0, 2),
(103, 'Locação (Movimentação)', NULL, NULL, 71, '', 1, NULL, NULL, 0, 1),
(104, 'Resumo dos Lançamentos', '?module=relatorio&acao=lista_locmovreslancamento', NULL, 103, 'relLocacaoResumoLancamentos', 1, NULL, NULL, 0, 2),
(105, 'Média de Lançamentos por Período', '?module=relatorio&acao=lista_locmovmedialanper', NULL, 103, 'relLocacaoMediaLancamentos', 1, NULL, NULL, 0, 2),
(106, 'Lançamentos por Categorias', '?module=relatorio&acao=lista_locmovlancategoria', NULL, 103, 'relLocacaoLancamentosPorCategoria', 1, NULL, NULL, 0, 2),
(107, 'Resumo de Cobrança em Aberto - Locatários', '?module=relatorio&acao=lista_locmovcobaberto', NULL, 103, 'relLocacaoResumoPendenciasInquilino', 1, NULL, NULL, 0, 2),
(108, 'Relação dos Recibos em Aberto - Locatários', '?module=relatorio&acao=lista_locmovrecatrasoinquilino', NULL, 103, 'relLocacaoRecibosEmAtrasoInquilino', 1, NULL, NULL, 0, 2),
(109, 'Relação dos Recibos em Aberto - Locatores', '?module=relatorio&acao=lista_locmovrecatrasoproprietario', NULL, 103, 'relLocacaoRecibosEmAtrasoProprietario', 1, NULL, NULL, 0, 2),
(110, 'Simulação de Reajustes', '?module=relatorio&acao=lista_locmovsimulareajuste', NULL, 103, 'relLocacaoSimulacaoReajuste', 1, NULL, NULL, 0, 2),
(111, 'Taxa de Administração', '?module=relatorio&acao=lista_locmovtaxaadm', NULL, 103, 'relLocacaoTaxaAdministracao', 1, NULL, NULL, 0, 2),
(112, 'Comprovante de Rendimentos - DIMOB', '?module=relatorio&acao=lista_locmovtaxaadm', NULL, 103, 'relLocacaoRelacaoDIMOB', 1, NULL, NULL, 0, 2),
(113, 'Locação (Contratos)', NULL, NULL, 71, '', 1, NULL, NULL, 0, 1),
(114, 'Entrada / Saída', '?module=relatorio&acao=lista_locconentradasaida', NULL, 113, 'relLocacaoContratosEntradaSaida', 1, NULL, NULL, 0, 2),
(115, 'Por Negociador', '?module=relatorio&acao=lista_locconnegociador', NULL, 113, 'relLocacaoContratosNegociador', 1, NULL, NULL, 0, 2),
(116, 'Por Angariador', '?module=relatorio&acao=lista_locconangariador', NULL, 113, 'relLocacaoContratosAngariador', 1, NULL, NULL, 0, 2),
(117, 'Por Locador', '?module=relatorio&acao=lista_locconlocador', NULL, 113, 'relLocacaoContratosLocador', 1, NULL, NULL, 0, 2),
(118, 'Pessoas', '?module=relatorio&acao=lista_locconpessoa', NULL, 113, 'relLocacaoContratosPessoas', 1, NULL, NULL, 0, 2),
(119, 'Por Data de Término', '?module=relatorio&acao=lista_loccontermino', NULL, 113, 'relLocacaoContratosTermino', 1, NULL, NULL, 0, 2),
(120, 'Por Data de Aviso', '?module=relatorio&acao=lista_locconaviso', NULL, 113, 'relLocacaoContratosAviso_REMOVER', 1, NULL, NULL, 0, 2),
(121, 'Por Tipo de Garantia', '?module=relatorio&acao=lista_loccongarantia', NULL, 113, 'relLocacaoContratosTipoGarantia', 1, NULL, NULL, 0, 2),
(122, 'Perfil - Cliente', '?module=relatorio&acao=lista_locconperfilcliente', NULL, 113, 'relLocacaoPerfilClientes', 1, NULL, NULL, 0, 2),
(123, 'IPTU', '?module=relatorio&acao=lista_locconiptu', NULL, 113, 'relLocacaoContratosIptu', 1, NULL, NULL, 0, 2),
(124, 'Manutenção por Prestadores', '?module=relatorio&acao=lista_locmantencaoprestador', NULL, 94, 'relManutencaoPrestador', 1, NULL, NULL, 0, 2),
(125, 'Manutenção - Avaliação Prestador', '?module=relatorio&acao=lista_locmantencaoavaliacao', NULL, 94, 'relManutencaoPrestadorAvaliacao', 1, NULL, NULL, 0, 2),
(126, 'Manutenção - Comissão', '?module=relatorio&acao=lista_locmantencaocomissao', NULL, 94, 'relManutencaoComissao', 1, NULL, NULL, 0, 2),
(127, 'Manutenção - Tempo de Conclusão', '?module=relatorio&acao=lista_locmantencaoconclusao', NULL, 94, 'relManutencaoTempoConclusao', 1, NULL, NULL, 0, 2),
(128, 'Financeiro', NULL, NULL, 71, '', 1, NULL, NULL, 0, 1),
(129, 'Movimento', '?module=relatorio&acao=lista_finmovimento', NULL, 128, 'relFinanceiroMovimento', 1, NULL, NULL, 0, 2),
(130, 'Caixa', '?module=relatorio&acao=lista_fincaixa', NULL, 128, 'relFinanceiroCaixa', 1, NULL, NULL, 0, 2),
(131, 'Caixa por Período', '?module=relatorio&acao=lista_fincaixaperiodo', NULL, 128, 'relFinanceiroCaixaPeriodo', 1, NULL, NULL, 0, 2),
(132, 'Resumo Caixa', '?module=relatorio&acao=lista_finresumocaixa', NULL, 128, 'relFinanceiroMovimentoResumo', 1, NULL, NULL, 0, 2),
(133, 'Pagar/Receber em Aberto', '?module=relatorio&acao=lista_finpagarreceber', NULL, 128, 'relFinanceiroPagarReceberAberto', 1, NULL, NULL, 0, 2),
(134, 'DRE Financeira', '?module=relatorio&acao=lista_findre', NULL, 128, 'relFinanceiroDREFinanceira', 1, NULL, NULL, 0, 2),
(135, 'Resumo Títulos por Categoria', '?module=relatorio&acao=lista_fintitulo', NULL, 128, 'relFinanceiroResumoCategorias', 1, NULL, NULL, 0, 2),
(136, 'Imóveis da Cidade', '?module=sistema&acao=lista_imoveiscidade', NULL, 1, 'imcConsultar', 1, NULL, NULL, 0, 1),
(137, 'Portal WEB', NULL, NULL, 1, '', 1, NULL, NULL, 0, 1),
(138, 'Viva Real', '?module=portalweb&acao=lista_vivareal', NULL, 137, 'pwVivaReal', 1, NULL, NULL, 0, 2),
(139, 'Imóveis-SC', '?module=portalweb&acao=lista_imoveissc', NULL, 137, 'pwImoveisSC', 1, NULL, NULL, 0, 2),
(140, 'Chave Fácil', '?module=portalweb&acao=lista_chavefacil', NULL, 137, 'pwChaveFacil', 1, NULL, NULL, 0, 2),
(141, 'Atendimento (CRM)', NULL, 'application/icons/atendimento.svg', NULL, '', 1, NULL, NULL, 0, 0),
(142, 'Vendas', NULL, NULL, 141, '', 1, NULL, NULL, 0, 1),
(143, 'Pretendentes', '?module=pretendente&acao=lista_pretendente', NULL, 142, 'relVendasPretendentes', 1, NULL, NULL, 0, 2),
(144, 'Agenda', '?module=pretendente&acao=lista_agenda', NULL, 142, 'relAgenda', 1, NULL, NULL, 0, 2),
(145, 'Visitas', '?module=pretendente&acao=lista_visitas', NULL, 142, 'venVisitas', 1, NULL, NULL, 0, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sisusuarios`
--

CREATE TABLE `sisusuarios` (
  `usu_codigo` int(11) NOT NULL,
  `usu_ativado` set('s','n') NOT NULL,
  `usu_email` varchar(100) NOT NULL,
  `usu_senha` varchar(100) NOT NULL,
  `usu_nome` varchar(100) NOT NULL,
  `usu_telefone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `sisusuarios`
--

INSERT INTO `sisusuarios` (`usu_codigo`, `usu_ativado`, `usu_email`, `usu_senha`, `usu_nome`, `usu_telefone`) VALUES
(1, 's', 'roberto.delavy@gmail.com', '1234', 'Roberto Delavi de Araújo', '(49) 9 9949-184'),
(2, 's', 'fulano@gmail.com', '1234', 'Fulano da Silva', '(49) 9 9143-154');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sisusuarios_sisempresas`
--

CREATE TABLE `sisusuarios_sisempresas` (
  `uem_codigo` int(1) UNSIGNED NOT NULL,
  `uem_ativado` set('s','n') DEFAULT 'n',
  `usu_codigo` int(11) NOT NULL,
  `emp_codigo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sisusuarios_sisempresas`
--

INSERT INTO `sisusuarios_sisempresas` (`uem_codigo`, `uem_ativado`, `usu_codigo`, `emp_codigo`) VALUES
(1, 's', 1, 1),
(2, 's', 2, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `sisempresas`
--
ALTER TABLE `sisempresas`
  ADD PRIMARY KEY (`emp_codigo`),
  ADD UNIQUE KEY `usu_apelido` (`emp_nome`),
  ADD KEY `emp_bd` (`emp_bd`);

--
-- Índices para tabela `sismenu`
--
ALTER TABLE `sismenu`
  ADD PRIMARY KEY (`men_codigo`);

--
-- Índices para tabela `sisusuarios`
--
ALTER TABLE `sisusuarios`
  ADD PRIMARY KEY (`usu_codigo`);

--
-- Índices para tabela `sisusuarios_sisempresas`
--
ALTER TABLE `sisusuarios_sisempresas`
  ADD PRIMARY KEY (`uem_codigo`),
  ADD UNIQUE KEY `usu_apelido` (`usu_codigo`),
  ADD KEY `emp_codigo` (`emp_codigo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `sisempresas`
--
ALTER TABLE `sisempresas`
  MODIFY `emp_codigo` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `sismenu`
--
ALTER TABLE `sismenu`
  MODIFY `men_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT de tabela `sisusuarios`
--
ALTER TABLE `sisusuarios`
  MODIFY `usu_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `sisusuarios_sisempresas`
--
ALTER TABLE `sisusuarios_sisempresas`
  MODIFY `uem_codigo` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
