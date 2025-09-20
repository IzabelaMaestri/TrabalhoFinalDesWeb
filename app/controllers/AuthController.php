<?php
require_once __DIR__ . "/../models/Usuario.php";

class AuthController extends Controller {
    public function login() {
        $erro = null;
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            
            $usuario = new Usuario();
            $dados = $usuario->login($email, $senha);
            if ($dados) {
                $_SESSION['usuario_id'] = $dados['id'];
                $_SESSION['usuario_nome'] = $dados['nome'];
                $_SESSION['usuario_tipo'] = $dados['tipo'];
                
                if ($dados['tipo'] === 'aluno') {
                    header("Location: ?route=dashboard/aluno");
                } else {
                    header("Location: ?route=dashboard/professor");
                }
                exit;
            } else {
                $erro = "Credenciais inválidas.";
            }
        }
        return $this->view("auth/login", compact('erro'));
    }

    public function cadastro() {
        $erro = null;
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome  = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $tipo  = $_POST['tipo'] ?? '';
            
            $nivel_escolar = null;
            if ($tipo === 'aluno') {
                $nivel_escolar = $_POST['nivel_escolar'] ?? null;
            }
            
            $usuario = new Usuario();
            if ($usuario->cadastrar($nome, $email, $senha, $tipo, $nivel_escolar)) {
                header("Location: ?route=auth/login&msg=cadastro_sucesso");
                exit;
            } else {
                $erro = "Erro ao cadastrar.";
            }
        }
        return $this->view("auth/cadastro", compact('erro'));
    }

    public function logout() {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: ?route=site/home&msg=logout_sucesso");
        exit;
    }
}
?>