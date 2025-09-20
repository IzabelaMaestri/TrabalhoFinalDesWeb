<?php
require_once __DIR__ . "/../models/Material.php";
require_once __DIR__ . "/../core/Database.php";

class MaterialController extends Controller {
    
    /**
     * Método dinâmico que redireciona baseado no tipo de usuário
     */
    public function meus() {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: ?route=auth/login"); 
            exit;
        }
        
        if ($_SESSION['usuario_tipo'] === 'professor') {
            return $this->meusProfessor();
        } else if ($_SESSION['usuario_tipo'] === 'aluno') {
            return $this->meusAluno();
        } else {
            header("Location: ?route=auth/login"); 
            exit;
        }
    }
    
    /**
     * Materiais do professor (CRUD completo)
     */
    public function meusProfessor() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== "professor") {
            header("Location: ?route=auth/login"); exit;
        }
        $m = new Material();
        $materiais = $m->listarPorUsuario($_SESSION['usuario_id']);
        return $this->view("professor/meus_materiais", compact('materiais'));
    }
    
    /**
     * Materiais que o aluno pode acessar (baseado nas suas disciplinas)
     */
    public function meusAluno() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== "aluno") {
            header("Location: ?route=auth/login"); exit;
        }
        
        // Buscar materiais das disciplinas que o aluno escolheu
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT DISTINCT m.*, mat.nome as materia_nome, u.nome as professor_nome
            FROM materiais m
            INNER JOIN materias mat ON m.materia_id = mat.id  
            INNER JOIN aluno_materias am ON mat.id = am.materia_id
            INNER JOIN usuarios u ON m.usuario_id = u.id
            WHERE am.aluno_id = ? AND m.ativo = 1
            ORDER BY m.created_at DESC
        ");
        $stmt->execute([$_SESSION['usuario_id']]);
        $materiais = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $this->view("aluno/meus_materiais", compact('materiais'));
    }

    /**
     * Método dinâmico para formulário - redireciona baseado no tipo de usuário
     */
    public function form() {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: ?route=auth/login"); 
            exit;
        }
        
        if ($_SESSION['usuario_tipo'] === 'professor') {
            return $this->formProfessor();
        } else if ($_SESSION['usuario_tipo'] === 'aluno') {
            // Aluno não pode criar materiais, redireciona para seus materiais
            header("Location: ?route=material/meus"); 
            exit;
        } else {
            header("Location: ?route=auth/login"); 
            exit;
        }
    }
    
    /**
     * Formulário de materiais para professor
     */
    public function formProfessor() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== "professor") {
            header("Location: ?route=auth/login"); exit;
        }

        $m = new Material();
        $id = $_GET['id'] ?? null;
        $material = $id ? $m->buscar($id) : null;

        // Buscar matérias disponíveis para o dropdown
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT id, nome FROM materias WHERE ativa = 1 ORDER BY nome");
        $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $titulo = $_POST['titulo'];
            $descricao = $_POST['descricao'];
            $tipo = $_POST['tipo'];
            $materia_id = $_POST['materia_id']; // Corrigido: usar materia_id em vez de disciplina
            $nivel = $_POST['nivel'];
            $link = $_POST['link'];

            $arquivo = $_FILES['arquivo']['name'] ?? null;
            if ($arquivo) {
                $dest = "public/uploads/" . basename($arquivo);
                move_uploaded_file($_FILES['arquivo']['tmp_name'], $dest);
                $arquivo = basename($arquivo);
            }

            if ($id) {
                $m->atualizar($id, $titulo, $descricao, $tipo, $materia_id, $nivel, $link, $arquivo);
            } else {
                $m->cadastrar($titulo, $descricao, $tipo, $materia_id, $nivel, $link, $arquivo, $_SESSION['usuario_id']);
            }
            header("Location: ?route=material/meus");
            exit;
        }

        return $this->view("professor/cadastro_materiais", compact('material', 'materias'));
    }

    public function excluir() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== "professor") {
            header("Location: ?route=auth/login"); exit;
        }
        $id = $_GET['id'] ?? null;
        if ($id) {
            $m = new Material();
            $result = $m->excluir($id);
            
            // Se for requisição AJAX, retornar JSON
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
                exit;
            }
        }
        header("Location: ?route=material/meus");
        exit;
    }
    
    /**
     * Buscar materiais - dinâmico baseado no tipo de usuário
     */
    public function buscarMeus() {
        if (!isset($_SESSION['usuario_id'])) {
            http_response_code(401);
            echo json_encode(['erro' => 'Não autorizado']);
            exit;
        }
        
        if ($_SESSION['usuario_tipo'] === 'professor') {
            return $this->buscarMeusProfessor();
        } else if ($_SESSION['usuario_tipo'] === 'aluno') {
            return $this->buscarMeusAluno();
        } else {
            http_response_code(401);
            echo json_encode(['erro' => 'Tipo de usuário inválido']);
            exit;
        }
    }
    
    /**
     * Buscar materiais do professor
     */
    private function buscarMeusProfessor() {
        $termo = $_GET['q'] ?? '';
        $disciplina = $_GET['disciplina'] ?? '';
        $tipo = $_GET['tipo'] ?? '';
        
        $sql = "SELECT * FROM materiais WHERE usuario_id = ?";
        $params = [$_SESSION['usuario_id']];
        
        if ($termo) {
            $sql .= " AND (titulo LIKE ? OR descricao LIKE ?)";
            $params[] = "%$termo%";
            $params[] = "%$termo%";
        }
        
        if ($disciplina) {
            $sql .= " AND materia_id = ?";
            $params[] = $disciplina;
        }
        
        if ($tipo) {
            $sql .= " AND tipo = ?";
            $params[] = $tipo;
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode($resultados);
        exit;
    }
    
    /**
     * Buscar materiais disponíveis para o aluno
     */
    private function buscarMeusAluno() {
        $termo = $_GET['q'] ?? '';
        $disciplina = $_GET['disciplina'] ?? '';
        $tipo = $_GET['tipo'] ?? '';
        
        $sql = "
            SELECT DISTINCT m.*, mat.nome as materia_nome, u.nome as professor_nome
            FROM materiais m
            INNER JOIN materias mat ON m.materia_id = mat.id  
            INNER JOIN aluno_materias am ON mat.id = am.materia_id
            INNER JOIN usuarios u ON m.usuario_id = u.id
            WHERE am.aluno_id = ? AND m.ativo = 1
        ";
        $params = [$_SESSION['usuario_id']];
        
        if ($termo) {
            $sql .= " AND (m.titulo LIKE ? OR m.descricao LIKE ?)";
            $params[] = "%$termo%";
            $params[] = "%$termo%";
        }
        
        if ($disciplina) {
            $sql .= " AND m.materia_id = ?";
            $params[] = $disciplina;
        }
        
        if ($tipo) {
            $sql .= " AND m.tipo = ?";
            $params[] = $tipo;
        }
        
        $sql .= " ORDER BY m.created_at DESC";
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode($resultados);
        exit;
    }
    
    /**
     * Visualizar material - dinâmico baseado no tipo de usuário
     */
    public function visualizar() {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: ?route=auth/login"); 
            exit;
        }
        
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: ?route=material/meus");
            exit;
        }
        
        $m = new Material();
        $material = $m->buscar($id);
        
        if (!$material) {
            header("Location: ?route=material/meus");
            exit;
        }
        
        // Verificar permissões baseadas no tipo de usuário
        if ($_SESSION['usuario_tipo'] === 'professor') {
            // Professor pode ver todos os materiais (ou apenas os seus para edição)
            // Aqui você pode adicionar lógica específica se necessário
        } else if ($_SESSION['usuario_tipo'] === 'aluno') {
            // Aluno só pode ver materiais das suas disciplinas
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                SELECT COUNT(*) as pode_acessar
                FROM materiais m
                INNER JOIN aluno_materias am ON m.materia_id = am.materia_id
                WHERE m.id = ? AND am.aluno_id = ? AND m.ativo = 1
            ");
            $stmt->execute([$id, $_SESSION['usuario_id']]);
            $permissao = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$permissao || $permissao['pode_acessar'] == 0) {
                $_SESSION['erro'] = 'Você não tem permissão para acessar este material.';
                header("Location: ?route=material/meus");
                exit;
            }
            
            // Registrar acesso do aluno
            $stmt = $db->prepare("
                INSERT INTO acessos (aluno_id, material_id, data_acesso) 
                VALUES (?, ?, NOW())
                ON DUPLICATE KEY UPDATE data_acesso = NOW()
            ");
            $stmt->execute([$_SESSION['usuario_id'], $id]);
        }
        
        return $this->view("material/visualizar", compact('material'));
    }
    
    // Método para cadastro de materiais (alias para form)
    public function cadastro() {
        return $this->form();
    }
    
    // Método para salvar material (alias para form que já processa POST)
    public function salvar() {
        return $this->form();
    }
    
    // Método para listar materiais do professor
    public function meusMateriais() {
        return $this->meus();
    }
    
    // Método para editar material
    public function editar() {
        return $this->form();
    }
} 
?>
