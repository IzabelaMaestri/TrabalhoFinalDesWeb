<?php
class Controller {
    /**
     * Renderiza uma view
     * 
     * @param string $view Nome da view (ex: "aluno/dashboard")
     * @param array $data Dados passados para a view
     * @param bool $layout Se true (padrão), inclui header e footer; se false, renderiza view pura
     */
    protected function view($view, $data = [], $layout = true) {
        extract($data);
        $file = __DIR__ . "/../views/$view.php";
        
        if (file_exists($file)) {
            if ($layout) {
                include __DIR__ . "/../views/partials/header.php";
                include $file;
                include __DIR__ . "/../views/partials/footer.php";
            } else {
                include $file;
            }
        } else {
            echo "<h3>View $view não encontrada</h3>";
        }
    }
}
?>
