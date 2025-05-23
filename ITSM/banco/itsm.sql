-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21/05/2025 às 19:25
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `itsm`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `incidentes`
--

CREATE TABLE `incidentes` (
  `id` int(11) NOT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `titulo` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `prioridade` varchar(30) NOT NULL,
  `criado_por` int(11) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atribuido_para` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `incidentes`
--

INSERT INTO `incidentes` (`id`, `codigo`, `titulo`, `descricao`, `status`, `prioridade`, `criado_por`, `criado_em`, `atribuido_para`) VALUES
(2, 'INC0002', 'Impressora não funciona', 'Descrição automática do incidente 2.', 3, 'Alta', 7, '2025-05-10 13:54:35', 3),
(3, 'INC0003', 'Sistema de ponto caiu', 'Descrição automática do incidente 3.', 3, 'Alta', 2, '2025-05-10 13:54:35', NULL),
(4, 'INC0004', 'Falha no acesso à internet', 'Descrição automática do incidente 4.', 3, 'Alta', 7, '2025-05-10 13:54:35', NULL),
(5, 'INC0005', 'Aplicativo trava constantemente', 'Descrição automática do incidente 5.', 2, 'Alta', 8, '2025-05-10 13:54:35', 5),
(6, 'INC0006', 'Erro ao abrir planilhas', 'Descrição automática do incidente 6.', 4, 'Baixa', 8, '2025-05-10 13:54:35', NULL),
(8, 'INC0008', 'Backup não foi concluído', 'Descrição automática do incidente 8.', 1, 'Crítica', 6, '2025-05-10 13:54:35', NULL),
(9, 'INC0009', 'Falha na VPN corporativa', 'Descrição automática do incidente 9.', 2, 'Baixa', 10, '2025-05-10 13:54:35', NULL),
(10, 'INC0010', 'Monitor com tela preta', 'Descrição automática do incidente 10.', 7, 'Crítica', 1, '2025-05-10 13:54:35', NULL),
(11, 'INC0011', 'Teclado parou de funcionar', 'Descrição automática do incidente 11.', 2, 'Alta', 11, '2025-05-10 13:54:35', NULL),
(12, 'INC0012', 'Teste', 'retberber', 4, 'Baixa', 1, '2025-05-10 16:20:54', NULL),
(13, 'INC0013', 'Teste2', 'ytrnrtnbrt', 4, 'Baixa', 1, '2025-05-10 16:52:13', NULL),
(14, 'INC0014', 'Teste', 'teste', 8, 'Baixa', 3, '2025-05-12 01:47:59', 3),
(15, 'INC0015', 'Teste', 'teste', 8, 'Baixa', 5, '2025-05-12 01:53:22', 5),
(16, 'INC0016', 'fghmnhgn', 'grgbtv', 8, 'Baixa', 6, '2025-05-12 01:54:58', NULL),
(17, 'INC0017', 'hvighiuhikm,pçl', 'ckghutfijnjgfvuijfyuhgon', 1, 'Alta', 3, '2025-05-19 01:04:34', NULL);

--
-- Acionadores `incidentes`
--
DELIMITER $$
CREATE TRIGGER `trg_incidentes_codigo` BEFORE INSERT ON `incidentes` FOR EACH ROW BEGIN
    DECLARE novo_codigo VARCHAR(10);
    DECLARE ultimo_id INT;

    IF NEW.codigo IS NULL THEN
        SELECT IFNULL(MAX(id), 0) + 1 INTO ultimo_id FROM incidentes;
        SET novo_codigo = CONCAT('INC', LPAD(ultimo_id, 4, '0'));
        SET NEW.codigo = novo_codigo;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `requisicoes`
--

CREATE TABLE `requisicoes` (
  `id` int(11) NOT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `titulo` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `tipo` varchar(30) NOT NULL,
  `status` int(11) NOT NULL,
  `criado_por` int(11) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atribuido_para` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `requisicoes`
--

INSERT INTO `requisicoes` (`id`, `codigo`, `titulo`, `descricao`, `tipo`, `status`, `criado_por`, `criado_em`, `atribuido_para`) VALUES
(2, 'REQ0002', 'Pedido de notebook novo', 'Descrição automática da requisição 2.', 'Software', 5, 6, '2025-05-10 13:54:35', NULL),
(3, 'REQ0003', 'Instalação de Adobe Photoshop', 'Descrição automática da requisição 3.', 'Software', 8, 6, '2025-05-10 13:54:35', 5),
(4, 'REQ0004', 'Criação de e-mail institucional', 'Descrição automática da requisição 4.', 'Acesso', 8, 2, '2025-05-10 13:54:35', NULL),
(5, 'REQ0005', 'Aumento de armazenamento no OneDrive', 'Descrição automática da requisição 5.', 'Acesso', 5, 4, '2025-05-10 13:54:35', NULL),
(6, 'REQ0006', 'Troca de monitor 24 polegadas', 'Descrição automática da requisição 6.', 'Hardware', 6, 6, '2025-05-10 13:54:35', NULL),
(7, 'REQ0007', 'Instalação do Microsoft Project', 'Descrição automática da requisição 7.', 'Software', 7, 2, '2025-05-10 13:54:35', NULL),
(8, 'REQ0008', 'Acesso ao repositório Git', 'Descrição automática da requisição 8.', 'Software', 6, 11, '2025-05-10 13:54:35', NULL),
(9, 'REQ0009', 'Atualização de licença do antivírus', 'Descrição automática da requisição 9.', 'Software', 5, 8, '2025-05-10 13:54:35', NULL),
(10, 'REQ0010', 'Cadastro em grupo do Teams', 'Descrição automática da requisição 10.', 'Software', 6, 9, '2025-05-10 13:54:35', NULL),
(11, 'REQ0011', 'Instalação de Java JDK', 'Descrição automática da requisição 11.', 'Software', 8, 5, '2025-05-10 13:54:35', NULL),
(13, 'REQ0013', 'Abertura', 'Abertura', 'Acesso', 1, 1, '2025-05-10 16:20:00', NULL),
(15, 'REQ0015', 'Teste', 'Teste', 'Acesso', 7, 1, '2025-05-11 23:36:28', NULL),
(16, 'REQ0016', 'Teste', 'teste', 'Acesso', 7, 5, '2025-05-11 23:37:34', NULL),
(17, 'REQ0017', 'Teste', 'teste', 'Acesso', 7, 5, '2025-05-11 23:38:13', NULL),
(18, 'REQ0018', 'Teste', 'teste2', 'Acesso', 8, 5, '2025-05-12 00:12:40', NULL),
(19, 'REQ0019', '', '', '', 8, 1, '2025-05-12 00:15:22', NULL),
(20, 'REQ0020', '', '', 'Acesso', 7, 1, '2025-05-12 00:36:56', NULL),
(21, 'REQ0021', 'Teste', 'Teste', 'Acesso', 8, 1, '2025-05-12 00:52:25', NULL),
(22, 'REQ0022', 'Teste', 'Teste', 'Hardware', 7, 5, '2025-05-12 00:53:44', 5),
(23, 'REQ0023', 'Teste', 'Teste', 'Hardware', 7, 5, '2025-05-12 01:07:17', NULL);

--
-- Acionadores `requisicoes`
--
DELIMITER $$
CREATE TRIGGER `trg_requisicoes_codigo` BEFORE INSERT ON `requisicoes` FOR EACH ROW BEGIN
    DECLARE novo_codigo VARCHAR(10);
    DECLARE ultimo_id INT;

    IF NEW.codigo IS NULL THEN
        SELECT IFNULL(MAX(id), 0) + 1 INTO ultimo_id FROM requisicoes;
        SET novo_codigo = CONCAT('REQ', LPAD(ultimo_id, 4, '0'));
        SET NEW.codigo = novo_codigo;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `status`
--

INSERT INTO `status` (`id`, `nome`) VALUES
(1, 'Aberto'),
(8, 'Cancelado'),
(7, 'Concluído'),
(6, 'Em análise'),
(2, 'Em andamento'),
(4, 'Fechado'),
(5, 'Pendente'),
(3, 'Resolvido');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `funcao` varchar(50) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `ativo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `login`, `senha`, `email`, `funcao`, `criado_em`, `ativo`) VALUES
(1, 'João da Silva', 'joaos', 'senha123', 'joao.silva@email.com', 'Solicitante', '2025-05-10 13:54:35', 1),
(2, 'Maria Oliveira', 'mariao', 'senha123', 'maria.oliveira@email.com', 'Atendente', '2025-05-10 13:54:35', 1),
(3, 'Carlos Souza', 'carloss', 'senha', 'carlos.souza@email.com', 'Administrador', '2025-05-10 13:54:35', 1),
(4, 'Ana Pereira', 'anap', 'senha123', 'ana.pereira@email.com', 'Solicitante', '2025-05-10 13:54:35', 1),
(5, 'Bruno Lima', 'brunol', 'senha123', 'bruno.lima@email.com', 'Atendente', '2025-05-10 13:54:35', 1),
(6, 'Fernanda Rocha', 'fernandar', 'senha123', 'fernanda.rocha@email.com', 'Solicitante', '2025-05-10 13:54:35', 1),
(7, 'Diego Alves', 'diegoa', 'senha123', 'diego.alves@email.com', 'Administrador', '2025-05-10 13:54:35', 1),
(8, 'Luciana Martins', 'lucianam', 'senha123', 'luciana.martins@email.com', 'Solicitante', '2025-05-10 13:54:35', 1),
(9, 'Pedro Henrique', 'pedroh', 'senha123', 'pedro.henrique@email.com', 'Atendente', '2025-05-10 13:54:35', 1),
(10, 'Juliana Costa', 'julianac', 'senha123', 'juliana.costa@email.com', 'Solicitante', '2025-05-10 13:54:35', 1),
(11, 'Rafael Torres', 'rafaelt', 'senha123', 'rafael.torres@email.com', 'Solicitante', '2025-05-10 13:54:35', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `incidentes`
--
ALTER TABLE `incidentes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `status` (`status`),
  ADD KEY `criado_por` (`criado_por`),
  ADD KEY `fk_atribuido_para_incidente` (`atribuido_para`);

--
-- Índices de tabela `requisicoes`
--
ALTER TABLE `requisicoes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `status` (`status`),
  ADD KEY `criado_por` (`criado_por`),
  ADD KEY `fk_atribuido_para_requisicao` (`atribuido_para`);

--
-- Índices de tabela `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `incidentes`
--
ALTER TABLE `incidentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `requisicoes`
--
ALTER TABLE `requisicoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `incidentes`
--
ALTER TABLE `incidentes`
  ADD CONSTRAINT `fk_atribuido_para_incidente` FOREIGN KEY (`atribuido_para`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `incidentes_ibfk_1` FOREIGN KEY (`status`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `incidentes_ibfk_2` FOREIGN KEY (`criado_por`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `requisicoes`
--
ALTER TABLE `requisicoes`
  ADD CONSTRAINT `fk_atribuido_para_requisicao` FOREIGN KEY (`atribuido_para`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `requisicoes_ibfk_1` FOREIGN KEY (`status`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `requisicoes_ibfk_2` FOREIGN KEY (`criado_por`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
