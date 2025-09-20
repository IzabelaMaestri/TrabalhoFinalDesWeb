<?php
require_once __DIR__ . "/../core/Database.php";

class Material {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function cadastrar($titulo,$descricao,$tipo,$materia_id,$nivel,$link,$arquivo,$uid) {
        $stmt = $this->db->prepare("
            INSERT INTO materiais 
            (titulo, descricao, tipo, materia_id, nivel_dificuldade, url_externa, caminho_arquivo, professor_id, ativo) 
            VALUES (?,?,?,?,?,?,?,?,1)
        ");
        return $stmt->execute([$titulo,$descricao,$tipo,$materia_id,$nivel,$link,$arquivo,$uid]);
    }

    public function atualizar($id,$titulo,$descricao,$tipo,$materia_id,$nivel,$link,$arquivo=null) {
        $query = "UPDATE materiais 
                  SET titulo=?, descricao=?, tipo=?, materia_id=?, nivel_dificuldade=?, url_externa=?";
        $params = [$titulo,$descricao,$tipo,$materia_id,$nivel,$link];
        if ($arquivo) {
            $query .= ", caminho_arquivo=?";
            $params[] = $arquivo;
        }
        $query .= " WHERE id=?";
        $params[] = $id;

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function excluir($id) {
        $stmt = $this->db->prepare("DELETE FROM materiais WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function listarPorUsuario($uid) {
        $stmt = $this->db->prepare("SELECT * FROM materiais WHERE professor_id=?");
        $stmt->execute([$uid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($id) {
        $stmt = $this->db->prepare("SELECT m.*, u.nome as professor, mat.nome as materia 
                                    FROM materiais m
                                    JOIN usuarios u ON m.professor_id = u.id
                                    JOIN materias mat ON m.materia_id = mat.id
                                    WHERE m.id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lista materiais para o aluno, baseado nas matérias que ele escolheu
     */
    public function materiaisPorDisciplinaAluno($uid) {
        $sql = "SELECT m.*, u.nome as professor, mat.nome as materia
                FROM materias_aluno ma
                JOIN materias mat ON ma.materia_id = mat.id
                JOIN materiais m ON m.materia_id = mat.id
                JOIN usuarios u ON m.professor_id = u.id
                WHERE ma.usuario_id = ? AND ma.ativa = 1 AND m.ativo = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$uid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarFavoritosPorAluno($alunoId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM favoritos WHERE usuario_id = ?");
        $stmt->execute([$alunoId]);
        return (int)$stmt->fetchColumn();
    }

    public function contarPorProfessor($professorId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM materiais WHERE professor_id = ?");
        $stmt->execute([$professorId]);
        return (int)$stmt->fetchColumn();
    }
}
?>
