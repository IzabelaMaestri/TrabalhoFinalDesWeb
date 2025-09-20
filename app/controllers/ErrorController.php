<?php
class ErrorController extends Controller {
    
    public function notFound() {
        http_response_code(404);
        $error = [
            'code' => 404,
            'title' => 'Página Não Encontrada',
            'message' => 'A página que você está procurando não existe ou foi removida.',
            'suggestion' => 'Verifique o endereço digitado ou volte à página inicial.'
        ];
        return $this->view("errors/404", compact('error'));
    }
    
    public function forbidden() {
        http_response_code(403);
        $error = [
            'code' => 403,
            'title' => 'Acesso Negado',
            'message' => 'Você não tem permissão para acessar esta página.',
            'suggestion' => 'Entre na sua conta ou contate o administrador.'
        ];
        return $this->view("errors/403", compact('error'));
    }
    
    public function internalError() {
        http_response_code(500);
        $error = [
            'code' => 500,
            'title' => 'Erro Interno do Servidor',
            'message' => 'Ocorreu um erro interno no servidor.',
            'suggestion' => 'Tente novamente em alguns instantes. Se o problema persistir, contate o suporte.'
        ];
        return $this->view("errors/500", compact('error'));
    }
    
    public function maintenance() {
        http_response_code(503);
        $error = [
            'code' => 503,
            'title' => 'Sistema em Manutenção',
            'message' => 'O sistema está temporariamente indisponível para manutenção.',
            'suggestion' => 'Voltaremos em breve. Obrigado pela compreensão.'
        ];
        return $this->view("errors/503", compact('error'));
    }
    
    public function database() {
        http_response_code(500);
        $error = [
            'code' => 500,
            'title' => 'Erro de Banco de Dados',
            'message' => 'Não foi possível conectar ao banco de dados.',
            'suggestion' => 'Verifique sua conexão e tente novamente.'
        ];
        return $this->view("errors/database", compact('error'));
    }
    
    public function custom($code = 500, $title = 'Erro', $message = 'Ocorreu um erro', $suggestion = '') {
        http_response_code($code);
        $error = [
            'code' => $code,
            'title' => $title,
            'message' => $message,
            'suggestion' => $suggestion
        ];
        return $this->view("errors/custom", compact('error'));
    }
}
?>
