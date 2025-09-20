<?php
require_once __DIR__ . "/../models/Usuario.php";

class UsuarioController extends Controller {
    public function perfil() {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: ?route=auth/login"); exit;
        }

        $u = new Usuario();
        $usuario = $u->buscarPorId($_SESSION['usuario_id']);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome  = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'] ?? null;
            $desc  = $_POST['descricao'] ?? null;

            $foto = $_FILES['foto']['name'] ?? null;
            if ($foto) {
                $dest = "public/uploads/" . basename($foto);
                move_uploaded_file($_FILES['foto']['tmp_name'], $dest);
                $foto = basename($foto);
            }

            $u->atualizar($_SESSION['usuario_id'], $nome, $email, $senha, $desc, $foto);
            header("Location: ?route=usuario/perfil&msg=salvo");
            exit;
        }

        return $this->view("auth/perfil", compact('usuario'));
    }

    public function excluirConta() {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: ?route=auth/login"); 
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?route=auth/perfil&erro=metodo_invalido");
            exit;
        }
        
        try {
            $usuarioId = $_SESSION['usuario_id'];
            $usuario = new Usuario();
            
            if ($usuario->excluir($usuarioId)) {
                $_SESSION = array();
                if (ini_get("session.use_cookies")) {
                    $params = session_get_cookie_params();
                    setcookie(session_name(), '', time() - 42000,
                        $params["path"], $params["domain"],
                        $params["secure"], $params["httponly"]
                    );
                }
                session_destroy();
                header("Location: ?route=site/home&msg=conta_excluida");
                exit;
            } else {
                header("Location: ?route=auth/perfil&erro=erro_exclusao");
                exit;
            }
        } catch (Exception $e) {
            error_log("Erro ao excluir conta: " . $e->getMessage());
            header("Location: ?route=auth/perfil&erro=erro_sistema");
            exit;
        }
    }
}
?>
