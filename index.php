<?php
// Carregar configurações primeiro
require_once __DIR__ . "/config.php";

// Iniciar sessão se não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Carregar classes core
require_once __DIR__ . "/app/core/Router.php";
require_once __DIR__ . "/app/core/Controller.php";
require_once __DIR__ . "/app/core/Database.php";

// Configurar manipulador de erros global
set_error_handler(function($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return false;
    }
    
    $errorData = [
        'title' => 'Erro do Sistema',
        'message' => 'Ocorreu um erro inesperado no sistema.',
        'suggestion' => 'Tente recarregar a página ou contacte o suporte se o problema persistir.',
        'severity' => 'medium',
        'type' => 'system_error',
        'context' => [
            'Severidade' => $severity,
            'Mensagem' => $message,
            'Arquivo' => basename($file),
            'Linha' => $line,
            'Hora' => date('d/m/Y H:i:s')
        ]
    ];
    
    if (DEBUG) {
        $errorData['debug'] = "Erro {$severity}: {$message} em {$file}:{$line}";
    }
    
    // Log do erro
    logError("PHP Error: {$message}", [
        'severity' => $severity,
        'file' => $file,
        'line' => $line
    ]);
    
    // Carregar ErrorController se possível
    $errorControllerFile = __DIR__ . "/app/controllers/ErrorController.php";
    if (file_exists($errorControllerFile)) {
        require_once $errorControllerFile;
        $errorController = new ErrorController();
        $errorController->custom($errorData);
        exit;
    }
    
    return false;
});

// Configurar manipulador de exceções não tratadas
set_exception_handler(function($exception) {
    $errorData = [
        'title' => 'Erro Crítico do Sistema',
        'message' => 'Ocorreu um erro crítico no sistema.',
        'suggestion' => 'Por favor, contacte o administrador do sistema.',
        'severity' => 'critical',
        'type' => 'exception',
        'context' => [
            'Tipo' => get_class($exception),
            'Mensagem' => $exception->getMessage(),
            'Arquivo' => basename($exception->getFile()),
            'Linha' => $exception->getLine(),
            'Hora' => date('d/m/Y H:i:s')
        ]
    ];
    
    if (DEBUG) {
        $errorData['debug'] = $exception->getTraceAsString();
    }
    
    // Log da exceção
    logError("Uncaught Exception: " . $exception->getMessage(), [
        'type' => get_class($exception),
        'file' => $exception->getFile(),
        'line' => $exception->getLine(),
        'trace' => $exception->getTraceAsString()
    ]);
    
    // Carregar ErrorController se possível
    $errorControllerFile = __DIR__ . "/app/controllers/ErrorController.php";
    if (file_exists($errorControllerFile)) {
        require_once $errorControllerFile;
        $errorController = new ErrorController();
        $errorController->internalError($errorData);
        exit;
    }
    
    // Fallback
    http_response_code(500);
    echo "Erro crítico do sistema. Contacte o administrador.";
    exit;
});

try {
    // Inicializar roteador e processar requisição
    $router = new Router();
    $route = $_GET['route'] ?? "site/home";
    
    // Validar rota básica
    if (!preg_match('/^[a-zA-Z0-9_\/]+$/', $route)) {
        throw new InvalidArgumentException("Rota inválida fornecida");
    }
    
    $router->dispatch($route);
    
} catch (Exception $e) {
    // Log do erro
    logError("Application Error: " . $e->getMessage(), [
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'route' => $route ?? 'unknown'
    ]);
    
    // Redirecionar para página de erro
    $errorControllerFile = __DIR__ . "/app/controllers/ErrorController.php";
    if (file_exists($errorControllerFile)) {
        require_once $errorControllerFile;
        $errorController = new ErrorController();
        $errorController->internalError([
            'title' => 'Erro na Aplicação',
            'message' => 'Ocorreu um erro ao processar a sua requisição.',
            'suggestion' => 'Tente novamente ou contacte o suporte.',
            'context' => [
                'Erro' => $e->getMessage(),
                'Arquivo' => basename($e->getFile()),
                'Linha' => $e->getLine()
            ]
        ]);
    } else {
        http_response_code(500);
        echo "Erro interno do servidor.";
    }
}
