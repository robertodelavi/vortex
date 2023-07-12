-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12/07/2023 às 11:02
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
-- Banco de dados: `vortex_nostracasa`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `imovelfoto`
--

CREATE TABLE `imovelfoto` (
  `imf_imovel` int(1) UNSIGNED NOT NULL DEFAULT 0,
  `imf_codigo` int(1) UNSIGNED NOT NULL,
  `imf_arquivo` varchar(200) NOT NULL DEFAULT '',
  `imf_descricao` varchar(100) NOT NULL DEFAULT '',
  `imf_principal` char(1) NOT NULL DEFAULT 'n',
  `imf_ficha` char(1) NOT NULL DEFAULT 'n',
  `imf_web` char(1) NOT NULL DEFAULT 'n'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `imovelfoto`
--

INSERT INTO `imovelfoto` (`imf_imovel`, `imf_codigo`, `imf_arquivo`, `imf_descricao`, `imf_principal`, `imf_ficha`, `imf_web`) VALUES
(1, 1, '1-a.jpeg', 'Descrição da imagem aqui...', 'n', 'n', 'n'),
(1, 3, '1-b.jpeg', 'Descrição da imagem aqui...', 'n', 'n', 'n'),
(1, 4, '1-c.jpeg', 'Descrição da imagem aqui...', 'n', 'n', 'n'),
(1, 5, '1-d.jpeg', 'Descrição da imagem aqui...', 'n', 'n', 'n'),
(1, 6, '1-e.jpeg', 'Descrição da imagem aqui...', 'n', 'n', 'n'),
(1, 7, '1-f.jpeg', 'Descrição da imagem aqui...', 's', 'n', 'n'),
(1, 8, '1-g.jpeg', 'Descrição da imagem aqui...', 'n', 'n', 'n'),
(1, 9, '1-h.jpeg', 'Descrição da imagem aqui...', 'n', 'n', 'n'),
(1, 10, '1-i.jpeg', 'Descrição da imagem aqui...', 'n', 'n', 'n'),
(1, 11, '1-j.jpeg', 'Descrição da imagem aqui...', 'n', 'n', 'n'),
(2, 12, '2-6cfdb12f6b8058441a5e48aae3aa2584_1366x768.jpeg', 'Descrição da imagem do imovel 2 aqui...', 'n', 'n', 'n'),
(2, 13, '2-23e1fd0a9936a979ab6d3e61f2f79482_1366x768.jpeg', 'Descrição da imagem do imovel 2 aqui...', 'n', 'n', 'n'),
(2, 14, '2-857f8dce8c0634b7db13b5f8a7f94586_1366x768.jpeg', 'Descrição da imagem do imovel 2 aqui...', 'n', 'n', 'n'),
(2, 15, '2-3612b477b7e54a957b0fdb1431d67a3a_1366x768.jpeg', 'Descrição da imagem do imovel 2 aqui...', 'n', 'n', 'n'),
(2, 16, '2-7353316ccd8b0bf08c3baee736e6052f_1366x768.jpeg', 'Descrição da imagem do imovel 2 aqui...', 'n', 'n', 'n'),
(2, 17, '2-a679369a7be1f82ec792f1e8cb2afa08_1366x768.jpeg', 'Descrição da imagem do imovel 2 aqui...', 's', 'n', 'n'),
(2, 18, '2-c8b350797d4a1a59fe562484336e1b6a_1366x768.jpeg', 'Descrição da imagem do imovel 2 aqui...', 'n', 'n', 'n'),
(2, 19, '2-d4bd6347dd6108dccd35287fd03ef038_1366x768.jpeg', 'Descrição da imagem do imovel 2 aqui...', 'n', 'n', 'n'),
(6, 20, '6-51cabbf205ebdda0e7a0ece7ac7f8783_1366x768.jpeg', 'Descrição do imovel 6 aqui..', 'n', 'n', 'n'),
(6, 21, '6-03624a26d0545efb2c8bd28aac2bc489_1366x768.jpeg', 'Descrição do imovel 6 aqui..', 'n', 'n', 'n'),
(6, 22, '6-28966638e995ff2100e1b1af9f1121f5_1366x768.jpeg', 'Descrição do imovel 6 aqui..', 'n', 'n', 'n'),
(6, 23, '6-a7f27ce3730b4cabb4563006e980532b_1366x768.jpeg', 'Descrição do imovel 6 aqui..', 'n', 'n', 'n'),
(6, 24, '6-abc8266a59f06b7340a78c4484f02f3b_1366x768.jpeg', 'Descrição do imovel 6 aqui..', 'n', 'n', 'n'),
(6, 25, '6-cb2611a07411f519d247186b022d3294_1366x768.jpeg', 'Descrição do imovel 6 aqui..', 'n', 'n', 'n'),
(6, 26, '6-ff7d9834c860f1744961be299f2d384a_1366x768.jpeg', 'Descrição do imovel 6 aqui..', 's', 'n', 'n'),
(7, 27, '7-0bec6096de47881c3985e707aab5a5dd_1366x768.jpeg', 'Descrição do imóvel 7 aqui..', 'n', 'n', 'n'),
(7, 28, '7-8f97e8dd733cbc799b31c6729219356c_1366x768.jpeg', 'Descrição do imóvel 7 aqui..', 'n', 'n', 'n'),
(7, 29, '7-40aa5a2081825e7bf2bb32f21925be68_1366x768.jpeg', 'Descrição do imóvel 7 aqui..', 'n', 'n', 'n'),
(7, 30, '7-99ce1de640e107a51d965852417aab4c_1366x768.jpeg', 'Descrição do imóvel 7 aqui..', 's', 'n', 'n'),
(7, 31, '7-0148b52b6cf1e81c919939d52b8c0210_1366x768.jpeg', 'Descrição do imóvel 7 aqui..', 'n', 'n', 'n'),
(7, 32, '7-159cb9b8dd562326193373962e7477c2_1366x768.jpeg', 'Descrição do imóvel 7 aqui..', 'n', 'n', 'n'),
(7, 33, '7-993e8698a6408a2f71dadbad63ac3889_1366x768.jpeg', 'Descrição do imóvel 7 aqui..', 'n', 'n', 'n'),
(7, 34, '7-61511c0c3c48999a71792c080d6836ae_1366x768.jpeg', 'Descrição do imóvel 7 aqui..', 'n', 'n', 'n'),
(7, 35, '7-ae786e66de372a42157c1bc4cdda4922_1366x768.jpeg', 'Descrição do imóvel 7 aqui..', 'n', 'n', 'n'),
(7, 36, '7-c2c839b615d4662c93495858ef33f6d2_1366x768.jpeg', 'Descrição do imóvel 7 aqui..', 'n', 'n', 'n');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `imovelfoto`
--
ALTER TABLE `imovelfoto`
  ADD PRIMARY KEY (`imf_imovel`,`imf_codigo`),
  ADD KEY `imf_imovel` (`imf_imovel`,`imf_codigo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `imovelfoto`
--
ALTER TABLE `imovelfoto`
  MODIFY `imf_codigo` int(1) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
