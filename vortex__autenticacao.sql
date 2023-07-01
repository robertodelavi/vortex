-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Jul-2023 às 16:07
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
  `men_ordem` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sismenu`
--

INSERT INTO `sismenu` (`men_codigo`, `men_nome`, `men_url`, `men_icone`, `men_pai`, `pro_nome`, `men_situacao`, `men_target`, `men_flag`, `men_ordem`) VALUES
(1, 'Sistema', NULL, 'application/icons/sistema.svg', NULL, '', 1, NULL, NULL, 0),
(2, 'Empresas', '?module=sistema&acao=lista_empresa', NULL, 1, 'sisEmpresas', 1, NULL, NULL, 0),
(3, 'Programas', '?module=sistema&acao=lista_programa', NULL, 1, 'sisProgramas', 1, NULL, NULL, 0),
(4, 'Cadastros', NULL, 'application/icons/refresh.svg', NULL, '', 1, NULL, NULL, 0),
(5, 'Financeiro', NULL, NULL, 4, '', 1, NULL, NULL, 0),
(6, 'Bancos', '?module=cadastro&acao=lista_finbanco', NULL, 5, 'cadBancos', 1, NULL, NULL, 0);

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
  MODIFY `men_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
