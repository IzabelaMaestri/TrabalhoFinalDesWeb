<?php
require_once __DIR__ . "/../core/Database.php";

class Acesso {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function registrar($uid, $mid) {
        $stmt = $this->db->prepare("INSERT INTO acessos (usuario_id, material_id) VALUES (?, ?)");
        return $stmt->execute([$uid, $mid]);
    }

    public function ultimosPorUsuario($uid, $limit = 5) {
        $sql = "SELECT a.*, m.titulo, mat.nome as materia, a.data_acesso
                FROM acessos a
                JOIN materiais m ON a.material_id = m.id
                JOIN materias mat ON m.materia_id = mat.id
                WHERE a.usuario_id = ? 
                ORDER BY a.data_acesso DESC 
                LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $uid, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarPorUsuario($uid) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM acessos WHERE usuario_id = ?");
        $stmt->execute([$uid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function contarPorMaterial($mid) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM acessos WHERE material_id = ?");
        $stmt->execute([$mid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function contarAcessosPorAluno($alunoId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM acessos WHERE usuario_id = ?");
        $stmt->execute([$alunoId]);
        return (int)$stmt->fetchColumn();
    }

    public function listarAcessosPorProfessor($professorId) {
        $sql = "SELECT a.*, mat.titulo
                FROM acessos a
                JOIN materiais mat ON a.material_id = mat.id
                WHERE mat.professor_id = ?
                ORDER BY a.data_acesso DESC
                LIMIT 10";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$professorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
