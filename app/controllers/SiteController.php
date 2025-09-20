<?php
class SiteController extends Controller {
    public function home() {
        return $this->view("site/home");
    }

    public function sobre() {
        return $this->view("site/sobre");
    }
    
    public function seed() {
        $db = Database::getInstance()->getConnection();

        // Limpar tabelas principais
        $db->exec("TRUNCATE usuarios");
        $db->exec("TRUNCATE materiais");
        $db->exec("TRUNCATE materias");
        $db->exec("TRUNCATE materias_aluno");
        $db->exec("TRUNCATE acessos");

        $alunoSenha = password_hash("12345678", PASSWORD_DEFAULT);
        $profSenha  = password_hash("12345678", PASSWORD_DEFAULT);

        // Criar aluno e professor
        $stmt = $db->prepare("INSERT INTO usuarios (nome,email,senha,tipo,nivel_escolar) VALUES (?,?,?,?,?)");
        $stmt->execute(["Aluno Exemplo","aluno@saber.com",$alunoSenha,"aluno","9º ano"]);
        $stmt->execute(["Professor Exemplo","prof@saber.com",$profSenha,"professor",null]);

        $prof_id  = $db->lastInsertId();
        $aluno_id = 1;

        // Criar materias base
        $stmtMat = $db->prepare("INSERT INTO materias (nome) VALUES (?), (?)");
        $stmtMat->execute(["História","Matemática"]);

        $historia_id = 1;
        $matematica_id = 2;

        // Inserir materiais vinculados às matérias
        $stmt2 = $db->prepare("INSERT INTO materiais (titulo,descricao,tipo,materia_id,nivel,link,professor_id,ativo) 
                               VALUES (?,?,?,?,?,?,?,1)");
        $stmt2->execute(["Revolução Francesa","Resumo histórico","video",$historia_id,"9º ano","https://youtu.be/teste",$prof_id]);
        $stmt2->execute(["Equações 2º Grau","Lista de exercícios","pdf",$matematica_id,"9º ano","https://example.com/pdf",$prof_id]);

        // Vincular aluno às matérias
        $stmt3 = $db->prepare("INSERT INTO materias_aluno (usuario_id,materia_id,ativa) VALUES (?,?,1),(?,?,1)");
        $stmt3->execute([$aluno_id,$historia_id,$aluno_id,$matematica_id]);

        echo "<h3>Seed concluído ✅</h3>
        <p>Aluno: aluno@saber.com / 12345678</p>
        <p>Professor: prof@saber.com / 12345678</p>";
    }
}
?>
