<?php
require_once __DIR__ . "/../models/Usuario.php";
require_once __DIR__ . "/../models/Material.php";
require_once __DIR__ . "/../core/Database.php";

class ProfessorController extends Controller {

    public function gerenciarAlunos() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'professor') {
            header("Location: ?route=auth/login");
            exit;
        }

        $this->db = Database::getInstance()->getConnection();
        $u = new Usuario();
        $alunos = $u->listarAlunos();
        
        $sqlMaterias = "SELECT id, nome FROM materias ORDER BY nome";
        $stmtMaterias = $this->db->prepare($sqlMaterias);
        $stmtMaterias->execute();
        $materias = $stmtMaterias->fetchAll(PDO::FETCH_ASSOC);

        return $this->view("professor/gerenciar_alunos", compact('alunos', 'materias'));
    }

    public function adicionarDisciplinaAluno() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'professor') {
            header("Location: ?route=auth/login"); exit;
        }

        $this->db = Database::getInstance()->getConnection();
        $alunoId = $_POST['aluno_id'] ?? '';
        $materiaId = $_POST['materia_id'] ?? '';

        if (empty($alunoId) || empty($materiaId)) {
            $_SESSION['erro'] = "Dados incompletos para adicionar matéria.";
            return;
        }

        try {
            $sqlCheck = "SELECT id FROM materias_aluno WHERE usuario_id = ? AND materia_id = ?";
            $stmtCheck = $this->db->prepare($sqlCheck);
            $stmtCheck->execute([$alunoId, $materiaId]);

            if ($stmtCheck->fetch()) {
                $_SESSION['aviso'] = "O aluno já possui esta matéria.";
            } else {
                $sql = "INSERT INTO materias_aluno (usuario_id, materia_id, data_escolha, ativa) VALUES (?, ?, NOW(), 1)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$alunoId, $materiaId]);
                $_SESSION['sucesso'] = "Matéria adicionada ao aluno com sucesso!";
            }
        } catch (Exception $e) {
            error_log("Erro ao adicionar matéria: " . $e->getMessage());
            $_SESSION['erro'] = "Erro ao adicionar matéria.";
        }
    }

    // ====================================================
    // CRUD DE MATERIAIS
    // ====================================================

    public function meusMateriais() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'professor') {
            header("Location: ?route=auth/login"); exit;
        }
        $m = new Material();
        $materiais = $m->listarPorUsuario($_SESSION['usuario_id']);
        return $this->view("professor/meus_materiais", compact('materiais'));
    }

    public function materialForm() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== "professor") {
            header("Location: ?route=auth/login"); exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $titulo = $_POST['titulo'] ?? null;
            $descricao = $_POST['descricao'] ?? null;
            $tipo = $_POST['tipo'] ?? null;
            $materia_id = $_POST['materia_id'] ?? null;
            $nivel = $_POST['nivel'] ?? null;
            $link = $_POST['link'] ?? null;
            $arquivo = $_FILES['arquivo']['name'] ?? null;

            if ($arquivo) {
                $dest = "public/uploads/" . basename($arquivo);
                move_uploaded_file($_FILES['arquivo']['tmp_name'], $dest);
                $arquivo = basename($arquivo);
            }

            $m = new Material();
            $m->cadastrar($titulo, $descricao, $tipo, $materia_id, $nivel, $link, $arquivo, $_SESSION['usuario_id']);
            header("Location: ?route=professor/meusMateriais&msg=material_salvo");
            exit;
        }

        return $this->view("professor/material_form");
    }

    public function editarMaterial() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== "professor") {
            header("Location: ?route=auth/login"); exit;
        }

        $id = $_GET['id'] ?? null;
        $m = new Material();

        if ($_SERVER["REQUEST_METHOD"] === "POST" && $id) {
            $titulo = $_POST['titulo'] ?? null;
            $descricao = $_POST['descricao'] ?? null;
            $tipo = $_POST['tipo'] ?? null;
            $materia_id = $_POST['materia_id'] ?? null;
            $nivel = $_POST['nivel'] ?? null;
            $link = $_POST['link'] ?? null;
            $arquivo = $_FILES['arquivo']['name'] ?? null;

            if ($arquivo) {
                $dest = "public/uploads/" . basename($arquivo);
                move_uploaded_file($_FILES['arquivo']['tmp_name'], $dest);
                $arquivo = basename($arquivo);
            }

            $m->atualizar($id, $titulo, $descricao, $tipo, $materia_id, $nivel, $link, $arquivo);
            header("Location: ?route=professor/meusMateriais&msg=material_editado");
            exit;
        }

        $material = $m->buscar($id);
        return $this->view("professor/material_form", compact('material'));
    }

    public function excluirMaterial() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== "professor") {
            header("Location: ?route=auth/login"); exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $m = new Material();
            $m->excluir($id);
            header("Location: ?route=professor/meusMateriais&msg=material_excluido");
            exit;
        } else {
            header("Location: ?route=erro/404");
            exit;
        }
    }
}
?>
