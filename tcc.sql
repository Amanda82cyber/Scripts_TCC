-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 19-Mar-2021 às 20:46
-- Versão do servidor: 10.3.16-MariaDB
-- versão do PHP: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `id15219962_tcc`
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
(1, '0000-00-00', '0000-00-00', 'NENHUMA'),
(10, '2021-05-31', '2021-03-26', 'AJUDE O MIGUELZINHO'),
(11, '2021-05-08', '2021-03-22', 'MAIS BIBLIOTECAS, SIM!'),
(12, '2021-04-12', '2021-03-17', 'QUERMESSE SãO JOãO');

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
  `CPF_usuario` varchar(14) DEFAULT NULL,
  `foto_doacao` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `doacoes`
--

INSERT INTO `doacoes` (`id_doacoes`, `descricao`, `quantidade`, `tipo`, `data_inicio`, `data_fim`, `arre_doar`, `id_campanha`, `cnpj_local`, `CPF_usuario`, `foto_doacao`) VALUES
(35, 'GORRO', 20, 'VESTIMENTAS', '2021-01-25', '2021-01-28', 'DOAÇÃO', 1, NULL, '449.180.408-70', '755373c0e68e1c460c678f324992c0d0.jpeg'),
(50, 'DOAçãO DE CESTA BáSICA', 100, 'ALIMENTÍCIA', '2021-01-12', '2021-01-16', 'DOAÇÃO', 1, NULL, '448.094.998-47', '28e466ae07cb37af91fa95408a522deb.png'),
(51, 'CARRINHO', 2, 'BRINQUEDOS', '2021-02-02', '2021-02-13', 'DOAÇÃO', 1, NULL, '111.111.111-11', '28a1818ec9c35abc0b47005a75dee24c.jpg'),
(53, 'ARRECADAçãO DE BRINQUEDOS', 60, 'BRINQUEDOS', '2021-03-29', '2021-04-09', 'ARRECADAÇÃO', 1, NULL, '472.036.318-00', ''),
(54, 'DOAçãO DE BANANAS', 50, 'ALIMENTÍCIA', '2021-04-01', '2021-04-21', 'DOAÇÃO', 1, NULL, '472.036.318-00', '188e16597921c5720669b5b8506b6fd6.jpg'),
(55, 'AJUDE O MIGUELZINHO!', 2500, 'MONETÁRIA', '2021-03-26', '2021-04-02', 'ARRECADAÇÃO', 10, NULL, '449.180.408-70', ''),
(56, 'ESTOU DOANDO JAQUETAS', 10, 'VESTIMENTAS', '2021-04-02', '2021-05-03', 'DOAÇÃO', 1, NULL, '448.094.998-47', '281449287ab247bc1205a643efe50296.jpg'),
(57, 'ESTOU ARRECADANDO LIVROS', 50, 'LIVROS', '2021-03-27', '2021-04-10', 'ARRECADAÇÃO', 11, NULL, '789.654.123-55', ''),
(58, 'ESTOU DOANDO POKEBOLAS', 5, 'BRINQUEDOS', '2021-03-23', '2021-04-09', 'DOAÇÃO', 1, NULL, '452.238.838-10', '81faa6736c11aafc1f55fc474bb10de0.png'),
(59, 'ESTOU ARRECADANDO ALIMENTOS PERECíVEIS', 50, 'ALIMENTÍCIA', '2021-03-22', '2021-04-17', 'ARRECADAÇÃO', 1, NULL, '367.351.268-40', ''),
(60, 'ESTOU DOANDO APOSTILAS ESCOLARES DO ANGLO', 4, 'APOSTILAS', '2021-03-20', '2021-04-10', 'DOAÇÃO', 1, NULL, '062.413.030-40', '06c31a2d534d9dbf3a4fad82c51026e9.jpg'),
(61, 'ESTOU ARRECADANDO SALSICHAS', 60, 'ALIMENTÍCIA', '2021-03-21', '2021-04-03', 'ARRECADAÇÃO', 12, NULL, '062.413.030-40', '');

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
('00000000000191', 'BANCO DO BRASIL SA', 'DIRECAO GERAL', '7744-5522', 'JOSE@GMAIL.COM', '789.654.123-55', 'JOSé', 14811540, 'PARQUE SãO PAULO (VILA XAVIER)', 'ARARAQUARA', 'SP', 'AVENIDA LUIZ ANTONIO CORREA DA SILVA', 147, '1234'),
('63919385000105', 'DROGA VEN LTDA', '', '3336-9000', 'DROGAVEMSRAFAEL@GMAIL.COM', '52150949857', 'RODRIGO FARO', 14806863, 'JARDIM SãO RAFAEL II', 'ARARAQUARA', 'SP', 'RUA MAURíCIO GALLI', 348, '1234');

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
('062.413.030-40', 'ALBERTO', '3336-5841', '99628-5147', 'ALBERTO@GMAIL.COM', 14811540, 'SP', 'PARQUE SãO PAULO (VILA XAVIER)', 'ARARAQUARA', 'AVENIDA LUIZ ANTONIO CORREA DA SILVA', 147, '1234'),
('111.111.111-11', 'FáBIO JUSTO', '(11)1111-1111', '(11)11111-1111', 'FABIOJJS@IFSP.EDU.BR', 11111111, 'SP', 'V. HARMONIA', 'ARARAQUARA', 'R JOSé M P FILHO', 881, '111111'),
('333.333.333-33', 'JOãO PEDRO ROMãO', '5555555', '555555', 'OJPZINHO@GMAIL.COM', 14820568, 'SP', 'JARDIM LUIZ OMETTO II', 'AMéRICO BRASILIENSE', 'AVENIDA ISACC AZEVEDO', 232, '123'),
('367.351.268-40', 'JADSON AUGUSTO DA SILVA', '(16)3461-2789', '(16)98813-7748', 'JADCODES@GMAIL.COM', 14808530, 'SP', 'PARQUE DAS HORTêNCIAS', 'ARARAQUARA', 'AVENIDA ARID NASSER', 156, '1234'),
('448.094.998-47', 'DEOCLéCIA ANDRADE DO NASCIMENTO', '3322-8265', '(16)99798-0735', 'DEINHAH.ANDRADE@GMAIL.COM', 14808464, 'SP', 'JARDIM IMPERIAL', 'ARARAQUARA', 'RUA ISIDORO BITIO NETO', 102, '123456'),
('449.180.408-70', 'CESAR L M JUNIOR', '16994221617', '(16)99422-1617', 'MOREIRAJR.CESAR@GMAIL.COM', 14811540, 'SP', 'PARQUE SãO PAULO (VILA XAVIER)', 'ARARAQUARA', 'AVENIDA LUIZ ANTONIO CORREA DA SILVA', 147, '4752'),
('452.238.838-10', 'GIOVANE NALIN', '16988668900', '(16)98866-8900', 'GIOVANE@EMAIL.COM', 14804081, 'SP', 'PARQUE RESIDENCIAL VALE DO SOL', 'ARARAQUARA', 'RUA JUVENAL RAMOS DE OLIVEIRA', 189, '123456'),
('472.036.318-00', 'AMANDA MOREIRA', '3333-5555', '99608-9898', 'NANDAMOREIRA945@GMAIL.COM', 14801000, 'SP', 'JARDIM CALIFóRNIA', 'ARARAQUARA', 'AVENIDA PRESIDENTE VARGAS', 147, '1234'),
('604.227.830-48', 'AMALIA MELO', '3324-5747', '99306-5637', 'AMALIA@EMAIL.COM', 14806222, 'SP', 'JARDIM SANTO ANTôNIO', 'ARARAQUARA', 'RUA LAZORETTA GIANSANTE ZUCCO', 230, '12345'),
('789.654.123-55', 'SAKURA BERNARDA', '3352-1458', '98852-6314', 'SAKURA@GMAIL.COM', 14801000, 'SP', 'JARDIM CALIFóRNIA', 'ARARAQUARA', 'AVENIDA PRESIDENTE VARGAS', 96, '123'),
('861.948.798-15', 'DECIO LAGO', '16997022008', '(16)99702-2008', 'DECIOLAGO@GMAIL.COM', 13566600, 'SP', 'VILA BRASíLIA', 'SãO CARLOS', 'RUA ARGENTINA', 375, 'Broinha01'),
('999.999.999-99', 'FáBIO JUSTO', '11911111111', '(11)11111-1111', 'FABIOJJS@IFSP.EDU.BR', 11111111, 'SP', 'V. HARMONIA', 'ARARAQUARA', 'R JOSé M P FILHO', 881, '111111');

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
  MODIFY `id_campanha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `doacoes`
--
ALTER TABLE `doacoes`
  MODIFY `id_doacoes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

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
