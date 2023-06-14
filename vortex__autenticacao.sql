-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14/06/2023 às 10:10
-- Versão do servidor: 10.4.17-MariaDB
-- Versão do PHP: 7.4.15

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
-- Estrutura para tabela `sisempresas`
--

CREATE TABLE `sisempresas` (
  `emp_codigo` int(1) UNSIGNED NOT NULL,
  `emp_ativado` set('s','n') DEFAULT 'n',
  `emp_nome` varchar(255) NOT NULL DEFAULT '',
  `emp_bd` varchar(255) NOT NULL COMMENT 'Nome do banco de dados para fazer conexão ao logar no sistema',
  `emp_email` varchar(150) NOT NULL DEFAULT '',
  `emp_telefone` varchar(50) NOT NULL DEFAULT '',
  `emp_cidade` varchar(255) NOT NULL,
  `emp_estado` varchar(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `sisempresas`
--

INSERT INTO `sisempresas` (`emp_codigo`, `emp_ativado`, `emp_nome`, `emp_bd`, `emp_email`, `emp_telefone`, `emp_cidade`, `emp_estado`) VALUES
(1, 's', 'Nostra Casa', 'vortex_nostracasa', 'contato@nostracasa.com.br', '(49) 3322-8466', 'Chapecó', 'SC'),
(2, 's', 'Santa Maria', 'vortex_santamaria', 'contato@santamaria.com.br', '(49) 3322-3387', 'Chapecó', 'SC');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sisusuarios`
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
-- Despejando dados para a tabela `sisusuarios`
--

INSERT INTO `sisusuarios` (`usu_codigo`, `usu_ativado`, `usu_email`, `usu_senha`, `usu_nome`, `usu_telefone`) VALUES
(1, 's', 'roberto.delavy@gmail.com', '1234', 'Roberto Delavi de Araújo', '(49) 9 9949-184'),
(2, 's', 'fulano@gmail.com', '1234', 'Fulano da Silva', '(49) 9 9143-154');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sisusuarios_sisempresas`
--

CREATE TABLE `sisusuarios_sisempresas` (
  `uem_codigo` int(1) UNSIGNED NOT NULL,
  `uem_ativado` set('s','n') DEFAULT 'n',
  `usu_codigo` int(11) NOT NULL,
  `emp_codigo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `sisusuarios_sisempresas`
--

INSERT INTO `sisusuarios_sisempresas` (`uem_codigo`, `uem_ativado`, `usu_codigo`, `emp_codigo`) VALUES
(1, 's', 1, 1),
(2, 's', 2, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `sisempresas`
--
ALTER TABLE `sisempresas`
  ADD PRIMARY KEY (`emp_codigo`),
  ADD UNIQUE KEY `usu_apelido` (`emp_nome`),
  ADD KEY `emp_bd` (`emp_bd`);

--
-- Índices de tabela `sisusuarios`
--
ALTER TABLE `sisusuarios`
  ADD PRIMARY KEY (`usu_codigo`);

--
-- Índices de tabela `sisusuarios_sisempresas`
--
ALTER TABLE `sisusuarios_sisempresas`
  ADD PRIMARY KEY (`uem_codigo`),
  ADD UNIQUE KEY `usu_apelido` (`usu_codigo`),
  ADD KEY `emp_codigo` (`emp_codigo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `sisempresas`
--
ALTER TABLE `sisempresas`
  MODIFY `emp_codigo` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
