-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 31-Mar-2021 às 03:46
-- Versão do servidor: 10.4.17-MariaDB
-- versão do PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `hackaton`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `markers`
--

CREATE TABLE `markers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `type` varchar(30) NOT NULL,
  `status` enum('on','off') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `markers`
--

INSERT INTO `markers` (`id`, `name`, `lat`, `lng`, `type`, `status`) VALUES
(2, 'ESCOLA PROFISSIONAL ANEXA AO CSU BIDU KRAUSE', -8.079551, -34.970394, '2', 'on'),
(3, 'Jardim Botânico do Recife', -8.075887, -34.966763, '2', 'on'),
(4, 'EMLURB', -8.101850, -34.928127, '2', 'on'),
(5, ' EMLURB', -8.058218, -34.888569, '2', 'on'),
(6, 'EMLURB', -8.056228, -34.895443, '2', 'on'),
(7, 'Prefeitura do Recife', -8.054226, -34.872330, '2', 'on'),
(8, 'Softex Recife', -8.061730, -34.871948, '2', 'on'),
(9, 'EcoEstação Campo Grande', -8.039158, -34.878349, '0', 'on'),
(10, ' Ecoestação Torre', -8.044163, -34.916264, '0', 'on'),
(11, 'Reciclagem Forte', -8.065521, -34.937210, '4', 'on'),
(12, 'Papel Norte', -8.072419, -34.911507, '5', 'on'),
(13, 'Vincents Reciclagem Ltda', -8.071945, -34.910427, '1', 'on'),
(14, 'Macunaíma gestão de resíduos sólidos ', -8.066411, -34.908375, '3', 'on'),
(15, 'Sucata Ferro Velho', -8.066276, -34.908348, '4', 'on'),
(16, 'FAUSTO AMBIENTAL', -8.080740, -34.917946, '3', 'on'),
(17, 'J W Reciclagem ', -8.076349, -34.909615, '1', 'on'),
(18, 'Adelson Reciclagem ', -8.080010, -34.904133, '5', 'on'),
(19, 'Ecoestaçõao Ibura', -8.123391, -34.915154, '0', 'on'),
(20, 'Latasa Reciclagem Ltda', -8.104242, -34.911785, '4', 'on'),
(21, 'Deposito de Reciclagem', -8.107789, -34.936523, '4', 'on'),
(22, 'Só Sucata', -8.027851, -34.893890, '4', 'on'),
(23, 'Reciclagem', -8.025560, -34.893486, '5', 'on'),
(24, 'Compra-se Sucata Reciclagem', -8.020871, -34.886337, '4', 'on'),
(25, 'Ecoestação do Arruda', -8.020343, -34.874519, '3', 'on'),
(26, 'CERCAP - Centro Brasileiro de Reciclagem e Capacitação Profissional', -8.051947, -34.902351, '5', 'on'),
(27, 'REEECicle - Inteligência em Reciclagem', -8.016251, -34.939941, '3', 'on'),
(28, 'Sucatão Xavier', -8.031139, -34.942963, '1', 'on'),
(29, 'Reciclagem Boa Viagem', -8.037626, -34.964176, '3', 'on'),
(30, 'PF Reciclagem', -8.036075, -34.929096, '1', 'on');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `markers`
--
ALTER TABLE `markers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `markers`
--
ALTER TABLE `markers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
