<?php
class ControllerBase {

    public function render($fileAdress, $data = []) {
        extract($data);
        include_once "Views/" . $fileAdress . ".php";
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

    public function requireAuthApi() {
        if (!isset($_SESSION['user']['id'])) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode(['error' => 'No Logged In']);
            exit;
        }
    }
}
?>