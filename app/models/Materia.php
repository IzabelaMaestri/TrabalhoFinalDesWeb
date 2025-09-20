<?php
require_once __DIR__ . "/../core/Database.php";

class Materia {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function listarTodas() {
        $stmt = $this->db->query("SELECT * FROM materias ORDER BY nome");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($id) {
        $stmt = $this->db->prepare("SELECT * FROM materias WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarPorAluno($alunoId) {
        $sql = "SELECT m.* FROM materias m
                JOIN materias_aluno ma ON m.id = ma.materia_id
                WHERE ma.usuario_id = ? AND ma.ativa = 1
                ORDER BY m.nome";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$alunoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarPorProfessor($professorId) {
        $sql = "SELECT COUNT(DISTINCT m.materia_id)
                FROM materiais m
                WHERE m.professor_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$professorId]);
        return (int)$stmt->fetchColumn();
    }
}
?>
