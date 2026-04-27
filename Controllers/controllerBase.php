<?php
class ControllerBase {

    public function render($pagina) {
        include_once $pagina;
    }
    
    public function redirect($url) {
        header('Location: ' . $url);
        exit;
    }

    public function requireAuth() {
        if (!isset($_SESSION['user']['id'])) {
            header('Location: ' . SITE_URL . 'index.php');
            exit;
        }
    }
}
?>