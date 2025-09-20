-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql307.infinityfree.com
-- Tempo de geração: 19/09/2025 às 20:00
-- Versão do servidor: 11.4.7-MariaDB
-- Versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `if0_39957673_saberconecta`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `acessos`
--

CREATE TABLE `acessos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `data_acesso` timestamp NULL DEFAULT current_timestamp(),
  `tempo_sessao` int(11) DEFAULT 0,
  `progresso` decimal(5,2) DEFAULT 0.00,
  `concluido` tinyint(1) DEFAULT 0,
  `dispositivo` varchar(100) DEFAULT NULL,
  `ip_acesso` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `acessos`
--

INSERT INTO `acessos` (`id`, `usuario_id`, `material_id`, `data_acesso`, `tempo_sessao`, `progresso`, `concluido`, `dispositivo`, `ip_acesso`) VALUES
(1, 2, 1, '2025-09-19 23:59:45', 1200, '75.50', 0, NULL, NULL),
(2, 2, 2, '2025-09-19 23:59:45', 2700, '100.00', 1, NULL, NULL),
(3, 2, 3, '2025-09-19 23:59:45', 900, '45.20', 0, NULL, NULL),
(4, 3, 1, '2025-09-19 23:59:45', 1800, '90.00', 0, NULL, NULL),
(5, 3, 4, '2025-09-19 23:59:45', 3600, '100.00', 1, NULL, NULL),
(6, 4, 2, '2025-09-19 23:59:45', 1500, '60.30', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `nota` int(11) NOT NULL
) ;

--
-- Despejando dados para a tabela `avaliacoes`
--

INSERT INTO `avaliacoes` (`id`, `usuario_id`, `material_id`, `nota`, `comentario`, `data_avaliacao`) VALUES
(1, 2, 2, 5, 'Excelente material! Muito bem explicado.', '2025-09-19 23:59:45'),
(2, 3, 4, 4, 'Boa simulação, ajudou a entender os conceitos.', '2025-09-19 23:59:45'),
(3, 4, 2, 5, 'Documentário muito interessante e educativo.', '2025-09-19 23:59:45');

-- --------------------------------------------------------

--
-- Estrutura para tabela `favoritos`
--

CREATE TABLE `favoritos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `data_favorito` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `materiais`
--

CREATE TABLE `materiais` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `tipo` enum('PDF','Video','Link','Apresentacao','Exercicio') NOT NULL,
  `caminho_arquivo` varchar(500) DEFAULT NULL,
  `url_externa` varchar(500) DEFAULT NULL,
  `materia_id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `nivel_dificuldade` enum('basico','intermediario','avancado') DEFAULT 'intermediario',
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ;

--
-- Despejando dados para a tabela `materiais`
--

INSERT INTO `materiais` (`id`, `titulo`, `descricao`, `tipo`, `caminho_arquivo`, `url_externa`, `materia_id`, `professor_id`, `nivel_dificuldade`, `tags`, `visualizacoes`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 'Equações do 2º Grau', 'Resolução completa de equações quadráticas com exemplos práticos', 'PDF', NULL, NULL, 1, 1, 'intermediario', '[\"algebra\", \"equacoes\", \"matematica\"]', 0, 1, '2025-09-19 23:59:44', '2025-09-19 23:59:44'),
(2, 'Revolução Industrial', 'Documentário sobre as transformações do século XVIII', 'Video', NULL, NULL, 2, 1, 'basico', '[\"historia\", \"revolucao\", \"industria\"]', 0, 1, '2025-09-19 23:59:44', '2025-09-19 23:59:44'),
(3, 'Células e Tecidos', 'Apresentação sobre estrutura celular e classificação de tecidos', 'Apresentacao', NULL, NULL, 3, 1, 'intermediario', '[\"biologia\", \"celulas\", \"anatomia\"]', 0, 1, '2025-09-19 23:59:44', '2025-09-19 23:59:44'),
(4, 'Leis de Newton', 'Simulação interativa das leis fundamentais da mecânica', 'Link', NULL, NULL, 4, 1, 'avancado', '[\"fisica\", \"mecanica\", \"newton\"]', 0, 1, '2025-09-19 23:59:44', '2025-09-19 23:59:44'),
(5, 'Análise Sintática', 'Exercícios práticos de identificação de termos da oração', 'Exercicio', NULL, NULL, 5, 1, 'intermediario', '[\"portugues\", \"gramatica\", \"sintaxe\"]', 0, 1, '2025-09-19 23:59:44', '2025-09-19 23:59:44'),
(6, 'Tabela Periódica', 'Guia completo dos elementos químicos e suas propriedades', 'PDF', NULL, NULL, 6, 1, 'basico', '[\"quimica\", \"elementos\", \"periodicidade\"]', 0, 1, '2025-09-19 23:59:44', '2025-09-19 23:59:44'),
(7, 'Relevo Brasileiro', 'Mapas e características das formas de relevo no Brasil', 'Apresentacao', NULL, NULL, 7, 1, 'intermediario', '[\"geografia\", \"relevo\", \"brasil\"]', 0, 1, '2025-09-19 23:59:44', '2025-09-19 23:59:44'),
(8, 'Verb Tenses', 'Tempos verbais em inglês com exercícios práticos', 'Exercicio', NULL, NULL, 8, 1, 'intermediario', '[\"ingles\", \"verbos\", \"gramatica\"]', 0, 1, '2025-09-19 23:59:44', '2025-09-19 23:59:44');

-- --------------------------------------------------------

--
-- Estrutura para tabela `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `categoria` enum('exatas','humanas','biologicas','linguagens') NOT NULL,
  `nivel` enum('fundamental','medio','superior') DEFAULT 'medio',
  `descricao` text DEFAULT NULL,
  `ativa` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `materias`
--

INSERT INTO `materias` (`id`, `nome`, `categoria`, `nivel`, `descricao`, `ativa`, `created_at`) VALUES
(1, 'Matemática', 'exatas', 'medio', 'Disciplina de matemática para ensino médio', 1, '2025-09-19 23:59:44'),
(2, 'História', 'humanas', 'medio', 'História geral e do Brasil', 1, '2025-09-19 23:59:44'),
(3, 'Biologia', 'biologicas', 'medio', 'Ciências biológicas e naturais', 1, '2025-09-19 23:59:44'),
(4, 'Física', 'exatas', 'medio', 'Física clássica e moderna', 1, '2025-09-19 23:59:44'),
(5, 'Português', 'linguagens', 'medio', 'Língua portuguesa e literatura', 1, '2025-09-19 23:59:44'),
(6, 'Química', 'exatas', 'medio', 'Química geral e orgânica', 1, '2025-09-19 23:59:44'),
(7, 'Geografia', 'humanas', 'medio', 'Geografia física e humana', 1, '2025-09-19 23:59:44'),
(8, 'Inglês', 'linguagens', 'medio', 'Língua inglesa básica e intermediária', 1, '2025-09-19 23:59:44'),
(9, 'Educação Física', 'biologicas', 'medio', 'Atividades físicas e esportivas', 1, '2025-09-19 23:59:44'),
(10, 'Artes', 'linguagens', 'medio', 'Educação artística e cultural', 1, '2025-09-19 23:59:44'),
(11, 'Filosofia', 'humanas', 'medio', 'Filosofia e pensamento crítico', 1, '2025-09-19 23:59:44'),
(12, 'Sociologia', 'humanas', 'medio', 'Sociedade e relações sociais', 1, '2025-09-19 23:59:44');

-- --------------------------------------------------------

--
-- Estrutura para tabela `materias_aluno`
--

CREATE TABLE `materias_aluno` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `data_escolha` timestamp NULL DEFAULT current_timestamp(),
  `ativa` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `materias_aluno`
--

INSERT INTO `materias_aluno` (`id`, `usuario_id`, `materia_id`, `data_escolha`, `ativa`) VALUES
(1, 2, 1, '2025-09-19 23:59:45', 1),
(2, 2, 2, '2025-09-19 23:59:45', 1),
(3, 2, 3, '2025-09-19 23:59:45', 1),
(4, 2, 5, '2025-09-19 23:59:45', 1),
(5, 3, 1, '2025-09-19 23:59:45', 1),
(6, 3, 4, '2025-09-19 23:59:45', 1),
(7, 3, 6, '2025-09-19 23:59:45', 1),
(8, 4, 2, '2025-09-19 23:59:45', 1),
(9, 4, 3, '2025-09-19 23:59:45', 1),
(10, 4, 5, '2025-09-19 23:59:45', 1),
(11, 4, 7, '2025-09-19 23:59:45', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessoes`
--

CREATE TABLE `sessoes` (
  `id` varchar(128) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `dados` text DEFAULT NULL,
  `data_criacao` timestamp NULL DEFAULT current_timestamp(),
  `data_expiracao` timestamp NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `ativa` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('aluno','professor') NOT NULL,
  `nivel_escolar` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`, `nivel_escolar`, `created_at`, `updated_at`) VALUES
(1, 'Professor Demo', 'professor@saberconecta.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'professor', NULL, '2025-09-19 23:59:44', '2025-09-19 23:59:44'),
(2, 'Aluno Demo', 'aluno@saberconecta.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'aluno', 'Médio', '2025-09-19 23:59:44', '2025-09-19 23:59:44'),
(3, 'João Silva', 'joao.silva@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'aluno', 'Fundamental', '2025-09-19 23:59:44', '2025-09-19 23:59:44'),
(4, 'Maria Santos', 'maria.santos@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'aluno', 'Superior', '2025-09-19 23:59:44', '2025-09-19 23:59:44'),
(5, 'Ana Costa', 'ana.costa@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'professor', NULL, '2025-09-19 23:59:44', '2025-09-19 23:59:44'),
(6, 'Amanda Leandro Soares do Carmo', 'amandaleandrosoares@gmail.com', '$2y$10$6d2tZz1QuYZcJiS9IAZgT.nfiloVhYY6/tnZftvdeH9NQfLnBZISq', 'professor', '', '2025-09-20 00:00:15', '2025-09-20 00:00:15');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `acessos`
--
ALTER TABLE `acessos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario_id` (`usuario_id`),
  ADD KEY `idx_material_id` (`material_id`),
  ADD KEY `idx_data_acesso` (`data_acesso`),
  ADD KEY `idx_concluido` (`concluido`),
  ADD KEY `idx_progresso` (`progresso`),
  ADD KEY `idx_acesso_usuario_data` (`usuario_id`,`DESC`);

--
-- Índices de tabela `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_usuario_material` (`usuario_id`,`material_id`),
  ADD KEY `idx_usuario_id` (`usuario_id`),
  ADD KEY `idx_material_id` (`material_id`),
  ADD KEY `idx_data_favorito` (`data_favorito`);

--
-- Índices de tabela `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD KEY `idx_nome` (`nome`),
  ADD KEY `idx_categoria` (`categoria`),
  ADD KEY `idx_nivel` (`nivel`),
  ADD KEY `idx_ativa` (`ativa`);

--
-- Índices de tabela `materias_aluno`
--
ALTER TABLE `materias_aluno`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_usuario_materia` (`usuario_id`,`materia_id`),
  ADD KEY `idx_usuario_id` (`usuario_id`),
  ADD KEY `idx_materia_id` (`materia_id`),
  ADD KEY `idx_data_escolha` (`data_escolha`),
  ADD KEY `idx_ativa` (`ativa`),
  ADD KEY `idx_usuario_materia_ativa` (`usuario_id`,`materia_id`,`ativa`);

--
-- Índices de tabela `sessoes`
--
ALTER TABLE `sessoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario_id` (`usuario_id`),
  ADD KEY `idx_data_expiracao` (`data_expiracao`),
  ADD KEY `idx_ativa` (`ativa`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_tipo` (`tipo`),
  ADD KEY `idx_nivel_escolar` (`nivel_escolar`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `acessos`
--
ALTER TABLE `acessos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `materiais`
--
ALTER TABLE `materiais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `materias_aluno`
--
ALTER TABLE `materias_aluno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `acessos`
--
ALTER TABLE `acessos`
  ADD CONSTRAINT `acessos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `acessos_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materiais` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materiais` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `materias_aluno`
--
ALTER TABLE `materias_aluno`
  ADD CONSTRAINT `materias_aluno_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `materias_aluno_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `sessoes`
--
ALTER TABLE `sessoes`
  ADD CONSTRAINT `sessoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
