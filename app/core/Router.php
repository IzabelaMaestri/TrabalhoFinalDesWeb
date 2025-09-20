<?php
class Router {
    private $routes = [];

    public function __construct() {
        // Carrega o arquivo de rotas que retorna um array $ROUTES
        $routesFile = __DIR__ . '/../routes.php';
        if (file_exists($routesFile)) {
            $routes = require $routesFile;
            if (is_array($routes)) {
                $this->routes = $routes;
            }
        }
    }

    public function add($route, $action) {
        $this->routes[$route] = $action;
    }

    public function getRoutes() {
        return $this->routes;
    }

    public function dispatch($route) {
        try {
            // 1. Verificar se rota está no mapa
            if (isset($this->routes[$route])) {
                [$controllerName, $method] = explode("@", $this->routes[$route]);
                $controllerFile = __DIR__ . "/../controllers/{$controllerName}.php";

                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    if (class_exists($controllerName)) {
                        $controller = new $controllerName();
                        if (method_exists($controller, $method)) {
                            return $controller->$method();
                        } else {
                            return $this->handleError(404);
                        }
                    } else {
                        return $this->handleError(404);
                    }
                } else {
                    return $this->handleError(404);
                }
            }

            // 2. Fallback: controller/metodo
            [$c, $m] = explode("/", $route) + [null, null];
            $controllerName = ucfirst($c) . "Controller";
            $method = $m ?: "index";
            $controllerFile = __DIR__ . "/../controllers/{$controllerName}.php";

            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    if (method_exists($controller, $method)) {
                        return $controller->$method();
                    } else {
                        return $this->handleError(404);
                    }
                } else {
                    return $this->handleError(404);
                }
            } else {
                return $this->handleError(404);
            }
        } catch (Exception $e) {
            return $this->handleError(500);
        }
    }

    private function handleError($code) {
        http_response_code($code);
        $controllerFile = __DIR__ . "/../controllers/ErrorController.php";
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            if (class_exists("ErrorController")) {
                $ec = new ErrorController();
                if ($code === 404) return $ec->notFound();
                if ($code === 403) return $ec->forbidden();
                if ($code === 503) return $ec->maintenance();
                return $ec->internalError();
            }
        }
        echo "<h1>Erro {$code}</h1>";
        return null;
    }
}
?>