-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 13-Out-2020 às 23:34
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tcc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `campanha`
--

CREATE TABLE `campanha` (
  `id_campanha` int(11) NOT NULL,
  `data_fim` date NOT NULL,
  `data_inicio` date NOT NULL,
  `descricao` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `campanha`
--

INSERT INTO `campanha` (`id_campanha`, `data_fim`, `data_inicio`, `descricao`) VALUES
(1, '2020-10-09', '2020-10-05', 'CAMPANHA DOS DIAS DAS CRIANçAS'),
(2, '2020-10-27', '2020-10-23', 'CAMPANHA DE INVERNO'),
(4, '2020-10-01', '2020-09-17', 'AJUDE O ZEZINHO'),
(5, '2020-10-23', '2020-10-19', 'ADOTE BATATAS');

-- --------------------------------------------------------

--
-- Estrutura da tabela `doacoes`
--

CREATE TABLE `doacoes` (
  `id_doacoes` int(11) NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `arre_doar` varchar(50) NOT NULL,
  `id_campanha` int(11) NOT NULL,
  `cnpj_local` varchar(20) DEFAULT NULL,
  `CPF_usuario` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `doacoes`
--

INSERT INTO `doacoes` (`id_doacoes`, `descricao`, `quantidade`, `tipo`, `data_inicio`, `data_fim`, `arre_doar`, `id_campanha`, `cnpj_local`, `CPF_usuario`) VALUES
(18, 'CASACO DE PELE', 3, 'VESTIMENTAS', '2020-09-02', '2020-09-10', 'DOAÇÃO', 2, NULL, '472.036.318-00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `local`
--

CREATE TABLE `local` (
  `CNPJ` varchar(20) NOT NULL,
  `razao_social` varchar(500) NOT NULL,
  `nome_fantasia` varchar(500) NOT NULL,
  `telefone` varchar(13) NOT NULL,
  `email` varchar(150) NOT NULL,
  `cpf_representante` varchar(14) NOT NULL,
  `nome_representante` varchar(150) NOT NULL,
  `CEP` int(11) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `logradouro` varchar(200) NOT NULL,
  `numero` int(11) NOT NULL,
  `senha` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `local`
--

INSERT INTO `local` (`CNPJ`, `razao_social`, `nome_fantasia`, `telefone`, `email`, `cpf_representante`, `nome_representante`, `CEP`, `bairro`, `cidade`, `estado`, `logradouro`, `numero`, `senha`) VALUES
('00000000000191', 'BANCO DO BRASIL SA', 'DIRECAO GERAL', '7744-5522', 'JOSE@GMAIL.COM', '789.654.123-55', 'JOSé', 14811540, 'PARQUE SãO PAULO (VILA XAVIER)', 'ARARAQUARA', 'SP', 'AVENIDA LUIZ ANTONIO CORREA DA SILVA', 147, '1234');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `CPF` varchar(14) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `telefone` varchar(13) NOT NULL,
  `celular` varchar(14) NOT NULL,
  `email` varchar(150) NOT NULL,
  `CEP` int(11) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `bairro` varchar(150) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `logradouro` varchar(250) NOT NULL,
  `numero` int(11) NOT NULL,
  `senha` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`CPF`, `nome`, `telefone`, `celular`, `email`, `CEP`, `estado`, `bairro`, `cidade`, `logradouro`, `numero`, `senha`) VALUES
('472.036.318-00', 'AMANDA MOREIRA', '3333-5555', '99608-9808', 'NANDAMOREIRA945@GMAIL.COM', 14801000, 'SP', 'JARDIM CALIFóRNIA', 'ARARAQUARA', 'AVENIDA PRESIDENTE VARGAS', 147, '1234'),
('789.654.123-55', 'SAKURA BERNARDA', '3352-1458', '98852-6314', 'SAKURA@GMAIL.COM', 14801000, 'SP', 'JARDIM CALIFóRNIA', 'ARARAQUARA', 'AVENIDA PRESIDENTE VARGAS', 96, '123');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `campanha`
--
ALTER TABLE `campanha`
  ADD PRIMARY KEY (`id_campanha`);

--
-- Índices para tabela `doacoes`
--
ALTER TABLE `doacoes`
  ADD PRIMARY KEY (`id_doacoes`),
  ADD KEY `id_campanha` (`id_campanha`),
  ADD KEY `cnpj_local` (`cnpj_local`),
  ADD KEY `CPF_usuario` (`CPF_usuario`);

--
-- Índices para tabela `local`
--
ALTER TABLE `local`
  ADD PRIMARY KEY (`CNPJ`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`CPF`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `campanha`
--
ALTER TABLE `campanha`
  MODIFY `id_campanha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `doacoes`
--
ALTER TABLE `doacoes`
  MODIFY `id_doacoes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `doacoes`
--
ALTER TABLE `doacoes`
  ADD CONSTRAINT `doacoes_ibfk_1` FOREIGN KEY (`id_campanha`) REFERENCES `campanha` (`id_campanha`) ON UPDATE CASCADE,
  ADD CONSTRAINT `doacoes_ibfk_2` FOREIGN KEY (`cnpj_local`) REFERENCES `local` (`CNPJ`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `doacoes_ibfk_3` FOREIGN KEY (`CPF_usuario`) REFERENCES `usuario` (`CPF`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
