-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Ago-2023 às 23:37
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `vortex_nostracasa`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `pretendentesstatusatendimento`
--

CREATE TABLE `pretendentesstatusatendimento` (
  `psa_codigo` int(1) UNSIGNED NOT NULL,
  `psa_descricao` varchar(100) NOT NULL DEFAULT '',
  `psa_cor` varchar(10) NOT NULL,
  `psa_ordem` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pretendentesstatusatendimento`
--

INSERT INTO `pretendentesstatusatendimento` (`psa_codigo`, `psa_descricao`, `psa_cor`, `psa_ordem`) VALUES
(1, 'Prospecção', '#E7515A', 1),
(2, 'Brifados', '#E2A03F', 2),
(3, 'Visita', '#4361EE', 3),
(4, 'Proposta', '#805dca', 4),
(5, 'Fechamento', '#00AB55', 5);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `pretendentesstatusatendimento`
--
ALTER TABLE `pretendentesstatusatendimento`
  ADD PRIMARY KEY (`psa_codigo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `pretendentesstatusatendimento`
--
ALTER TABLE `pretendentesstatusatendimento`
  MODIFY `psa_codigo` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
