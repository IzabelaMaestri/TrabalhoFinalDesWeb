<?php
// =============================================
// CONFIGURAÇÕES DO SABERCONECTA MVC
// =============================================

// Configurações de Banco de Dados
if (isset($_SERVER['HTTP_HOST']) && 
    strpos($_SERVER['HTTP_HOST'], 'infinityfree.me') !== false) {
    // Produção - InfinityFree
    define('DB_HOST', 'sql307.infinityfree.com');
    define('DB_NAME', 'if0_39957673_saberconecta');
    define('DB_USER', 'if0_39957673');
    define('DB_PASS', 'devweb2025');
} else {
    // Desenvolvimento - localhost
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'saberconecta');
    define('DB_USER', 'root');
    define('DB_PASS', '');
}

// Configurações da Aplicação
define('APP_NAME', 'Saber Conecta');
define('APP_URL', 'http://localhost:8080');
define('APP_VERSION', '1.0.0');

// Configurações de Upload
define('UPLOAD_PATH', 'public/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png']);

// Configurações de Debug e Erro
if (isset($_SERVER['HTTP_HOST']) && 
    strpos($_SERVER['HTTP_HOST'], 'infinityfree.me') !== false) {
    // Produção - InfinityFree
    error_reporting(0);
    ini_set('display_errors', 0);
    define('DEBUG', false);
} else if ($_SERVER['SERVER_NAME'] === 'localhost' || 
    $_SERVER['SERVER_ADDR'] === '127.0.0.1') {
    // Desenvolvimento - localhost
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    define('DEBUG', true);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    define('DEBUG', false);
}

// Configurações de erro
define('ERROR_REPORTING_LEVEL', E_ALL & ~E_NOTICE & ~E_WARNING);
define('DISPLAY_ERRORS', DEBUG);
define('LOG_ERRORS', true);

// Configurações de sessão
define('SESSION_NAME', 'saberconecta_session');
define('SESSION_LIFETIME', 3600); // 1 hora
define('SESSION_SECURE', false); // Definir como true em HTTPS
define('SESSION_HTTPONLY', true);

// Configurações de base de dados
define('DB_RETRY_ATTEMPTS', 3);
define('DB_RETRY_DELAY', 1); // segundos

// URLs do sistema
define('BASE_URL', '/');
define('ASSETS_URL', BASE_URL . 'public/assets/');

// Configurações de segurança
define('CSRF_TOKEN_NAME', 'csrf_token');
define('PASSWORD_MIN_LENGTH', 6);
define('LOGIN_MAX_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 300); // 5 minutos

// Configurações de Sessão (apenas se não há sessão ativa)
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_set_cookie_params([
        'lifetime' => SESSION_LIFETIME,
        'path' => '/',
        'domain' => '',
        'secure' => SESSION_SECURE,
        'httponly' => SESSION_HTTPONLY
    ]);
    ini_set('session.cookie_lifetime', SESSION_LIFETIME);
    ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
}

// Aplicar configurações de erro
if (DEBUG) {
    error_reporting(ERROR_REPORTING_LEVEL);
    ini_set('display_errors', DISPLAY_ERRORS);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

ini_set('log_errors', LOG_ERRORS);

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// =============================================
// FUNÇÕES HELPER
// =============================================

// Função helper para debug
function debug($data, $die = false) {
    if (DEBUG) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if ($die) {
            die();
        }
    }
}

// Função helper para log de erros customizado
function logError($message, $context = []) {
    $logMessage = date('Y-m-d H:i:s') . ' - ' . $message;
    if (!empty($context)) {
        $logMessage .= ' - Context: ' . json_encode($context);
    }
    error_log($logMessage);
}

// Função helper para gerar CSRF token
function generateCSRFToken() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

// Função helper para verificar CSRF token
function verifyCSRFToken($token) {
    return isset($_SESSION[CSRF_TOKEN_NAME]) && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

// Função helper para limpar dados de entrada
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Função helper para verificar se é requisição AJAX
function isAjaxRequest() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

// Função helper para retornar resposta JSON
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
?>
