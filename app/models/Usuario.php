<?php
require_once __DIR__ . "/../core/Database.php";

class Usuario {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function cadastrar($nome, $email, $senha, $tipo, $nivel_escolar = null) {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare(
            "INSERT INTO usuarios (nome, email, senha, tipo, nivel_escolar) VALUES (?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$nome, $email, $hash, $tipo, $nivel_escolar]);
    }

    public function existeEmail($email) {
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function login($email, $senha) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($senha, $user['senha'])) {
            return $user;
        }
        return false;
    }

    public function buscarPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $nome, $email, $tipo, $nivel_escolar = null) {
        $stmt = $this->db->prepare("UPDATE usuarios SET nome = ?, email = ?, tipo = ?, nivel_escolar = ? WHERE id = ?");
        return $stmt->execute([$nome, $email, $tipo, $nivel_escolar, $id]);
    }

    public function atualizarSenha($id, $nova_senha) {
        $hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
        return $stmt->execute([$hash, $id]);
    }

    public function listarPorTipo($tipo) {
        $stmt = $this->db->prepare("SELECT id, nome, email, tipo, nivel_escolar, created_at FROM usuarios WHERE tipo = ?");
        $stmt->execute([$tipo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluir($id) {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // 🔹 Métodos para dashboards
    public function contarMateriasAluno($alunoId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM materias_aluno WHERE usuario_id = ?");
        $stmt->execute([$alunoId]);
        return (int)$stmt->fetchColumn();
    }

    public function contarAlunosPorProfessor($professorId) {
        $sql = "SELECT COUNT(DISTINCT ma.usuario_id)
                FROM materias_aluno ma
                JOIN materiais m ON ma.materia_id = m.materia_id
                WHERE m.professor_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$professorId]);
        return (int)$stmt->fetchColumn();
    }
}
?>