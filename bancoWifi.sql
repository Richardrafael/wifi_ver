-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25-Abr-2024 às 12:57
-- Versão do servidor: 10.4.6-MariaDB
-- versão do PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `wifi`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `dados`
--

CREATE TABLE `dados` (
  `cd_conexao` int(11) NOT NULL,
  `dt_acesso` datetime NOT NULL,
  `nm_mac` varchar(18) DEFAULT NULL,
  `ds_nome` varchar(50) DEFAULT NULL,
  `ds_email` varchar(60) DEFAULT NULL,
  `ds_telefone` varchar(15) DEFAULT NULL,
  `sn_termo` varchar(1) DEFAULT NULL,
  `matricula` varchar(20) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `tipo_usuario` varchar(2) NOT NULL,
  `data_nasc` date DEFAULT NULL,
  `senha_toten` varchar(50) DEFAULT NULL,
  `crm` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `dados`
--

INSERT INTO `dados` (`cd_conexao`, `dt_acesso`, `nm_mac`, `ds_nome`, `ds_email`, `ds_telefone`, `sn_termo`, `matricula`, `cpf`, `tipo_usuario`, `data_nasc`, `senha_toten`, `crm`) VALUES
(1, '2024-04-11 09:30:12', '50:28:4a:bd:61:5e', 'Cintia Navarro Lamas', 'richard.rafael.soares@gmail.com', '(12) 15145-6132', 'S', NULL, '00000376809', 'vi', NULL, NULL, NULL),
(2, '2024-04-23 08:20:49', '50:28:4a:bd:61:5e', 'Cintia Navarro Lamas', 'richard.rafael.soares@gmail.com', '(12) 15145-6132', 'S', NULL, '52998224725', 'vi', NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `dados`
--
ALTER TABLE `dados`
  ADD PRIMARY KEY (`cd_conexao`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `dados`
--
ALTER TABLE `dados`
  MODIFY `cd_conexao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
