-- ====================================================
-- SCRIPT SQL COMPLETO - SABERCONECTA (RESET TOTAL)
-- ====================================================
-- InfinityFree compatível
-- ====================================================

-- Desabilitar checagem de chaves estrangeiras
SET FOREIGN_KEY_CHECKS = 0;

-- ====================================================
-- DROP TABLES (ordem não importa porque os checks estão desligados)
-- ====================================================
DROP TABLE IF EXISTS acessos;
DROP TABLE IF EXISTS avaliacoes;
DROP TABLE IF EXISTS favoritos;
DROP TABLE IF EXISTS sessoes;
DROP TABLE IF EXISTS materias_aluno;
DROP TABLE IF EXISTS materiais;
DROP TABLE IF EXISTS materias;
DROP TABLE IF EXISTS usuarios;

-- Reativar checagem de chaves estrangeiras
SET FOREIGN_KEY_CHECKS = 1;

-- ====================================================
-- TABELA: USUARIOS
-- ====================================================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('aluno','professor') NOT NULL,
    nivel_escolar VARCHAR(50) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================
-- TABELA: MATERIAS
-- ====================================================
CREATE TABLE materias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL UNIQUE,
    categoria ENUM('exatas', 'humanas', 'biologicas', 'linguagens') NOT NULL,
    nivel ENUM('fundamental', 'medio', 'superior') DEFAULT 'medio',
    descricao TEXT,
    ativa BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_nome (nome),
    INDEX idx_categoria (categoria),
    INDEX idx_nivel (nivel),
    INDEX idx_ativa (ativa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================
-- TABELA: MATERIAS_ALUNO
-- ====================================================
CREATE TABLE materias_aluno (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    materia_id INT NOT NULL,
    data_escolha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ativa BOOLEAN DEFAULT TRUE,
    
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (materia_id) REFERENCES materias(id) ON DELETE CASCADE,
    
    UNIQUE KEY unique_usuario_materia (usuario_id, materia_id),
    INDEX idx_usuario_id (usuario_id),
    INDEX idx_materia_id (materia_id),
    INDEX idx_data_escolha (data_escolha),
    INDEX idx_ativa (ativa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================
-- TABELA: MATERIAIS
-- ====================================================
CREATE TABLE materiais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    tipo ENUM('PDF', 'Video', 'Link', 'Apresentacao', 'Exercicio') NOT NULL,
    caminho_arquivo VARCHAR(500),
    url_externa VARCHAR(500),
    materia_id INT NOT NULL,
    professor_id INT NOT NULL,
    nivel_dificuldade ENUM('basico', 'intermediario', 'avancado') DEFAULT 'intermediario',
    tags JSON,
    visualizacoes INT DEFAULT 0,
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (materia_id) REFERENCES materias(id) ON DELETE CASCADE,
    FOREIGN KEY (professor_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    
    INDEX idx_titulo (titulo),
    INDEX idx_tipo (tipo),
    INDEX idx_materia_id (materia_id),
    INDEX idx_professor_id (professor_id),
    INDEX idx_nivel_dificuldade (nivel_dificuldade),
    INDEX idx_ativo (ativo),
    INDEX idx_created_at (created_at),
    
    FULLTEXT idx_busca_texto (titulo, descricao)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================
-- TABELA: ACESSOS
-- ====================================================
CREATE TABLE acessos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    material_id INT NOT NULL,
    data_acesso TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tempo_sessao INT DEFAULT 0,
    progresso DECIMAL(5,2) DEFAULT 0.00,
    concluido BOOLEAN DEFAULT FALSE,
    dispositivo VARCHAR(100),
    ip_acesso VARCHAR(45),
    
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (material_id) REFERENCES materiais(id) ON DELETE CASCADE,
    
    INDEX idx_usuario_id (usuario_id),
    INDEX idx_material_id (material_id),
    INDEX idx_data_acesso (data_acesso),
    INDEX idx_concluido (concluido),
    INDEX idx_progresso (progresso)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================
-- TABELA: AVALIACOES
-- ====================================================
CREATE TABLE avaliacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    material_id INT NOT NULL,
    nota INT NOT NULL CHECK (nota BETWEEN 1 AND 5),
    comentario TEXT,
    data_avaliacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (material_id) REFERENCES materiais(id) ON DELETE CASCADE,
    
    UNIQUE KEY unique_usuario_material (usuario_id, material_id),
    INDEX idx_usuario_id (usuario_id),
    INDEX idx_material_id (material_id),
    INDEX idx_nota (nota),
    INDEX idx_data_avaliacao (data_avaliacao)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================
-- TABELA: FAVORITOS
-- ====================================================
CREATE TABLE favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    material_id INT NOT NULL,
    data_favorito TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (material_id) REFERENCES materiais(id) ON DELETE CASCADE,
    
    UNIQUE KEY unique_usuario_material (usuario_id, material_id),
    INDEX idx_usuario_id (usuario_id),
    INDEX idx_material_id (material_id),
    INDEX idx_data_favorito (data_favorito)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================
-- TABELA: SESSOES
-- ====================================================
CREATE TABLE sessoes (
    id VARCHAR(128) PRIMARY KEY,
    usuario_id INT NOT NULL,
    dados TEXT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_expiracao TIMESTAMP NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    ativa BOOLEAN DEFAULT TRUE,
    
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    
    INDEX idx_usuario_id (usuario_id),
    INDEX idx_data_expiracao (data_expiracao),
    INDEX idx_ativa (ativa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================
-- DADOS INICIAIS
-- ====================================================
INSERT INTO usuarios (nome, email, senha, tipo, nivel_escolar) VALUES
('Professor Demo', 'professor@saberconecta.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'professor', NULL),
('Aluno Demo', 'aluno@saberconecta.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'aluno', 'Médio'),
('João Silva', 'joao.silva@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'aluno', 'Fundamental'),
('Maria Santos', 'maria.santos@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'aluno', 'Superior'),
('Ana Costa', 'ana.costa@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'professor', NULL);

INSERT INTO materias (nome, categoria, nivel, descricao) VALUES
('Matemática', 'exatas', 'medio', 'Disciplina de matemática para ensino médio'),
('História', 'humanas', 'medio', 'História geral e do Brasil'),
('Biologia', 'biologicas', 'medio', 'Ciências biológicas e naturais'),
('Física', 'exatas', 'medio', 'Física clássica e moderna'),
('Português', 'linguagens', 'medio', 'Língua portuguesa e literatura'),
('Química', 'exatas', 'medio', 'Química geral e orgânica'),
('Geografia', 'humanas', 'medio', 'Geografia física e humana'),
('Inglês', 'linguagens', 'medio', 'Língua inglesa básica e intermediária'),
('Educação Física', 'biologicas', 'medio', 'Atividades físicas e esportivas'),
('Artes', 'linguagens', 'medio', 'Educação artística e cultural'),
('Filosofia', 'humanas', 'medio', 'Filosofia e pensamento crítico'),
('Sociologia', 'humanas', 'medio', 'Sociedade e relações sociais');

INSERT INTO materiais (titulo, descricao, tipo, materia_id, professor_id, nivel_dificuldade, tags) VALUES
('Equações do 2º Grau', 'Resolução completa de equações quadráticas com exemplos práticos', 'PDF', 1, 1, 'intermediario', '["algebra", "equacoes", "matematica"]'),
('Revolução Industrial', 'Documentário sobre as transformações do século XVIII', 'Video', 2, 1, 'basico', '["historia", "revolucao", "industria"]'),
('Células e Tecidos', 'Apresentação sobre estrutura celular e classificação de tecidos', 'Apresentacao', 3, 1, 'intermediario', '["biologia", "celulas", "anatomia"]'),
('Leis de Newton', 'Simulação interativa das leis fundamentais da mecânica', 'Link', 4, 1, 'avancado', '["fisica", "mecanica", "newton"]'),
('Análise Sintática', 'Exercícios práticos de identificação de termos da oração', 'Exercicio', 5, 1, 'intermediario', '["portugues", "gramatica", "sintaxe"]'),
('Tabela Periódica', 'Guia completo dos elementos químicos e suas propriedades', 'PDF', 6, 1, 'basico', '["quimica", "elementos", "periodicidade"]'),
('Relevo Brasileiro', 'Mapas e características das formas de relevo no Brasil', 'Apresentacao', 7, 1, 'intermediario', '["geografia", "relevo", "brasil"]'),
('Verb Tenses', 'Tempos verbais em inglês com exercícios práticos', 'Exercicio', 8, 1, 'intermediario', '["ingles", "verbos", "gramatica"]');

INSERT INTO materias_aluno (usuario_id, materia_id) VALUES
(2, 1), (2, 2), (2, 3), (2, 5),
(3, 1), (3, 4), (3, 6),
(4, 2), (4, 3), (4, 5), (4, 7);

INSERT INTO acessos (usuario_id, material_id, tempo_sessao, progresso, concluido) VALUES
(2, 1, 1200, 75.50, FALSE),
(2, 2, 2700, 100.00, TRUE),
(2, 3, 900, 45.20, FALSE),
(3, 1, 1800, 90.00, FALSE),
(3, 4, 3600, 100.00, TRUE),
(4, 2, 1500, 60.30, FALSE);

INSERT INTO avaliacoes (usuario_id, material_id, nota, comentario) VALUES
(2, 2, 5, 'Excelente material! Muito bem explicado.'),
(3, 4, 4, 'Boa simulação, ajudou a entender os conceitos.'),
(4, 2, 5, 'Documentário muito interessante e educativo.');

-- ====================================================
-- ÍNDICES ADICIONAIS
-- ====================================================
CREATE INDEX idx_usuario_materia_ativa ON materias_aluno(usuario_id, materia_id, ativa);
CREATE INDEX idx_material_professor_ativo ON materiais(materia_id, professor_id, ativo);
CREATE INDEX idx_acesso_usuario_data ON acessos(usuario_id, data_acesso DESC);
CREATE INDEX idx_material_visualizacoes ON materiais(visualizacoes DESC, ativo);

-- ====================================================
-- SCRIPT CONCLUÍDO (RESET TOTAL)
-- ====================================================
