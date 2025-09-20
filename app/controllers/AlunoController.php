<?php
require_once __DIR__ . "/../models/Usuario.php";
require_once __DIR__ . "/../models/Material.php";
require_once __DIR__ . "/../models/Acesso.php";

class AlunoController extends Controller {

    public function dashboard() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== "aluno") {
            header("Location: ?route=auth/login"); exit;
        }

        $uid = $_SESSION['usuario_id'];
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT COUNT(*) as total FROM materiais WHERE ativo = 1");
        $stmt->execute();
        $totalMateriais = $stmt->fetch()['total'] ?? 0;

        $stmt = $db->prepare("SELECT COUNT(*) as total FROM materias_aluno WHERE usuario_id = ? AND ativa = 1");
        $stmt->execute([$uid]);
        $minhasMaterias = $stmt->fetch()['total'] ?? 0;

        $stmt = $db->prepare("
            SELECT m.titulo, m.tipo, ma.nome as materia, a.data_acesso 
            FROM acessos a 
            JOIN materiais m ON a.material_id = m.id 
            JOIN materias ma ON m.materia_id = ma.id 
            WHERE a.usuario_id = ? 
            ORDER BY a.data_acesso DESC 
            LIMIT 5
        ");
        $stmt->execute([$uid]);
        $ultimosAcessos = $stmt->fetchAll();

        $dados = [
            'totalMateriais' => $totalMateriais,
            'minhasMaterias' => $minhasMaterias,
            'ultimosAcessos' => $ultimosAcessos
        ];

        return $this->view("aluno/dashboard", $dados);
    }

    // ====================================================
    // VISÃO DE MATERIAS
    // ====================================================

    public function materiasDisponiveis() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== "aluno") {
            header("Location: ?route=auth/login"); exit;
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id, nome FROM materias ORDER BY nome");
        $stmt->execute();
        $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->view("aluno/materias_disponiveis", compact('materias'));
    }

    public function escolherMaterias() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== "aluno") {
            header("Location: ?route=auth/login"); exit;
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT materia_id FROM materias_aluno WHERE usuario_id = ? AND ativa = 1");
        $stmt->execute([$_SESSION['usuario_id']]);
        $disciplinasSelecionadas = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $this->view("aluno/escolher_materias", compact('disciplinasSelecionadas'));
    }

    public function salvarMaterias() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== "aluno") {
            header("Location: ?route=auth/login"); exit;
        }

        $db = Database::getInstance()->getConnection();
        $uid = $_SESSION['usuario_id'];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $materias = $_POST['materias'] ?? [];

            try {
                $stmt = $db->prepare("DELETE FROM materias_aluno WHERE usuario_id = ?");
                $stmt->execute([$uid]);

                if (!empty($materias)) {
                    $stmt = $db->prepare("INSERT INTO materias_aluno (usuario_id, materia_id, ativa) VALUES (?, ?, 1)");
                    foreach ($materias as $materiaId) {
                        $stmt->execute([$uid, $materiaId]);
                    }
                }

                $count = count($materias);
                header("Location: ?route=dashboard/aluno&msg=disciplinas_salvas&count={$count}");
                exit;
            } catch (Exception $e) {
                $erro = "Erro ao salvar matérias. Tente novamente.";
                return $this->view("aluno/escolher_materias", compact('erro'));
            }
        }
    }

    // ====================================================
    // MATERIAIS DO ALUNO
    // ====================================================

    public function meusMateriais() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== "aluno") {
            header("Location: ?route=auth/login"); exit;
        }

        $m = new Material();
        $materiais = $m->materiaisPorDisciplinaAluno($_SESSION['usuario_id']);
        return $this->view("aluno/meus_materiais", compact('materiais'));
    }

    public function favoritos() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== "aluno") {
            header("Location: ?route=auth/login"); exit;
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT m.*, mat.nome as materia_nome 
            FROM favoritos f
            JOIN materiais m ON f.material_id = m.id
            JOIN materias mat ON m.materia_id = mat.id
            WHERE f.usuario_id = ?
        ");
        $stmt->execute([$_SESSION['usuario_id']]);
        $materiais = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->view("aluno/favoritos", compact('materiais'));
    }

    public function recomendados() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== "aluno") {
            header("Location: ?route=auth/login"); exit;
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT m.*, mat.nome as materia_nome 
            FROM materiais m
            JOIN materias mat ON m.materia_id = mat.id
            WHERE m.ativo = 1
            ORDER BY RAND()
            LIMIT 10
        ");
        $stmt->execute();
        $materiais = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->view("aluno/recomendados", compact('materiais'));
    }

    public function acessarMaterial() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== "aluno") {
            header("Location: ?route=auth/login"); exit;
        }

        $material_id = $_GET['id'] ?? null;
        if ($material_id) {
            $a = new Acesso();
            $a->registrar($_SESSION['usuario_id'], $material_id);

            $m = new Material();
            $material = $m->buscar($material_id);

            if ($material) {
                return $this->view("aluno/material", compact('material'));
            } else {
                header("Location: ?route=erro/404");
                exit;
            }
        } else {
            header("Location: ?route=erro/404");
            exit;
        }
    }
}
?>
