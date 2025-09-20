<?php
class Database {
    private static $instance = null;
    private $conn;

    private $host;
    private $db;
    private $user;
    private $pass;

    private function __construct() {
        // Usar configurações do config.php
        $this->host = DB_HOST;
        $this->db = DB_NAME;
        $this->user = DB_USER;
        $this->pass = DB_PASS;
        
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4",
                $this->user,
                $this->pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                ]
            );
        } catch(PDOException $e) {
            $this->handleConnectionError($e);
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
    
    // ====================================================
    // Helpers de transação
    // ====================================================
    public function beginTransaction() {
        return $this->conn->beginTransaction();
    }

    public function commit() {
        return $this->conn->commit();
    }

    public function rollback() {
        return $this->conn->rollBack();
    }

    /**
     * Trata erros de conexão com a base de dados
     */
    private function handleConnectionError($exception) {
        $errorData = [
            'title' => 'Erro de Conexão com a Base de Dados',
            'message' => 'Não foi possível estabelecer conexão com a base de dados.',
            'suggestion' => 'Verifique se o servidor da base de dados está operacional e tente novamente.',
            'server' => $this->host,
            'database' => $this->db,
            'technical' => $exception->getMessage()
        ];
        
        error_log("Database Connection Error: " . $exception->getMessage());
        
        $controllerFile = __DIR__ . "/../controllers/ErrorController.php";
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            if (class_exists("ErrorController")) {
                $errorController = new ErrorController();
                return $errorController->database($errorData);
            }
        }

        echo "<h1>Erro de conexão</h1><p>{$exception->getMessage()}</p>";
        exit;
    }
}
?>
