# 🎓 SaberConecta - Sistema de Gestão Educacional

![Logo SaberConecta](public/assets/images/logo.jpeg)

## 📋 Sobre o Projeto

O **SaberConecta** é um sistema completo de gestão educacional desenvolvido em PHP com arquitetura MVC, criado especificamente para atender às necessidades acadêmicas da **Universidade Federal de Uberlândia (UFU)**. O sistema permite que professores compartilhem materiais educacionais e alunos gerenciem seu aprendizado de forma intuitiva e eficiente.

### 🎓 Projeto Acadêmico - UFU
- **Disciplina:** Desenvolvimento de Software I
- **Instituição:** Universidade Federal de Uberlândia (UFU)
- **Semestre:** 2025/1

## ✨ Funcionalidades Principais

### 👨‍🏫 Para Professores (Educadores)
- ✅ Cadastro e login no sistema
- ✅ Upload de materiais educacionais (PDF, vídeos, links, apresentações)
- ✅ Gerenciamento completo dos materiais (CRUD)
- ✅ Dashboard com estatísticas de acesso
- ✅ Busca AJAX em tempo real nos materiais
- ✅ Visualização de alunos cadastrados

### 👨‍🎓 Para Alunos (Estudantes)
- ✅ Cadastro e login no sistema
- ✅ Seleção de disciplinas de interesse
- ✅ Visualização de materiais por disciplina
- ✅ Busca AJAX com filtros avançados
- ✅ Dashboard personalizado
- ✅ Tracking de materiais acessados

### 🔧 Funcionalidades Técnicas
- ✅ Arquitetura MVC completa
- ✅ Sistema de rotas dinâmicas
- ✅ Autenticação e controle de sessão
- ✅ Upload seguro de arquivos
- ✅ Interface responsiva (Bootstrap 5)
- ✅ Funcionalidades AJAX para busca
- ✅ Banco de dados MySQL com relacionamentos

## 🛠️ Tecnologias Utilizadas

- **Backend:** PHP 8.3+
- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5
- **Banco de Dados:** MySQL
- **Arquitetura:** MVC (Model-View-Controller)
- **Bibliotecas:** PDO, Bootstrap Icons

## 🚀 Como Executar o Projeto

### Pré-requisitos
- PHP 8.3 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache/Nginx) ou PHP built-in server

### Passo a Passo

1. **Clone ou baixe o projeto:**
   ```bash
   git clone [url-do-repositorio]
   cd saberconecta_mvc
   ```

2. **Configure o banco de dados:**
   - Crie um banco MySQL chamado `saberconecta`
   - Importe o arquivo `sql/bd_saberconecta.sql`
   ```sql
   CREATE DATABASE saberconecta;
   USE saberconecta;
   SOURCE sql/bd_saberconecta.sql;
   ```

3. **Configure a conexão (se necessário):**
   - Edite o arquivo `app/core/Database.php` com suas credenciais
   - Por padrão está configurado para: localhost, root, sem senha

4. **Inicie o servidor:**
   ```bash
   php -S localhost:8080 -t .
   ```

5. **Acesse o sistema:**
   - Abra o navegador em: `http://localhost:8080`

### 👤 Usuários de Teste

O sistema inclui usuários de exemplo:

**Professores:**
- Email: `joao.silva@professor.com` | Senha: `password`
- Email: `maria.santos@professor.com` | Senha: `password`

**Alunos:**
- Email: `ana.clara@estudante.com` | Senha: `password`
- Email: `pedro.henrique@estudante.com` | Senha: `password`

## 📊 Banco de Dados

### Principais Tabelas:
- **usuarios:** Dados dos usuários (alunos e professores)
- **materiais:** Conteúdos educacionais cadastrados
- **acessos:** Tracking de visualizações
- **materias_aluno:** Disciplinas escolhidas pelo aluno

### Relacionamentos:
- Um professor pode ter vários materiais (1:N)
- Um material pode ter vários acessos (1:N)
- Um aluno pode escolher várias disciplinas (N:M)

## ⚡ Funcionalidades AJAX

- **Busca em tempo real** com debounce de 300ms
- **Filtros dinâmicos** por disciplina e tipo
- **Loading states** com spinners
- **Atualização sem reload** da página

## 👨‍💻 Desenvolvedor

Projeto desenvolvido para atender aos requisitos acadêmicos da UFU, implementando todas as funcionalidades solicitadas:

- ✅ Sistema MVC completo
- ✅ Autenticação e autorização
- ✅ CRUD de usuários e materiais
- ✅ Interface responsiva
- ✅ Banco de dados relacional
- ✅ Funcionalidades AJAX (pontuação extra)

---

🎓 **UFU - Universidade Federal de Uberlândia**