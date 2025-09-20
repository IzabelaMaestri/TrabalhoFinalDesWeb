<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Material.php';
require_once __DIR__ . '/../models/Acesso.php';
require_once __DIR__ . '/../models/Materia.php';

class DashboardController extends Controller
{
    public function aluno()
    {
        if ($_SESSION['usuario_tipo'] !== 'aluno') {
            header("Location: ?route=auth/login");
            exit;
        }

        $usuarioId = $_SESSION['usuario_id'];

        $usuarioModel  = new Usuario();
        $materialModel = new Material();
        $acessoModel   = new Acesso();

        $totalMaterias  = $usuarioModel->contarMateriasAluno($usuarioId);
        $totalFavoritos = $materialModel->contarFavoritosPorAluno($usuarioId);
        $totalAcessos   = $acessoModel->contarAcessosPorAluno($usuarioId);

        $this->view('aluno/dashboard', compact('totalMaterias', 'totalFavoritos', 'totalAcessos'));
    }

    public function professor()
    {
        if ($_SESSION['usuario_tipo'] !== 'professor') {
            header("Location: ?route=auth/login");
            exit;
        }

        $usuarioId = $_SESSION['usuario_id'];

        $usuarioModel  = new Usuario();
        $materialModel = new Material();
        $acessoModel   = new Acesso();
        $materiaModel  = new Materia();

        $totalAlunos     = $usuarioModel->contarAlunosPorProfessor($usuarioId);
        $totalMateriais  = $materialModel->contarPorProfessor($usuarioId);
        $totalMaterias   = $materiaModel->contarPorProfessor($usuarioId);
        $acessosRecentes = $acessoModel->listarAcessosPorProfessor($usuarioId);

        $this->view('professor/dashboard', compact('totalAlunos', 'totalMateriais', 'totalMaterias', 'acessosRecentes'));
    }
}
?>