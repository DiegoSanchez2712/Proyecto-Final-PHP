<?php
    session_start();
    require_once 'Controllers/controllerBase.php';
    require_once 'Controllers/controllerAuth.php';
    require_once 'config/config.php';
    require_once 'Models/conexion.php';
    require_once 'Models/user.php';
    $controllerBase = new ControllerBase();
    $controllerAuth = new ControllerAuth();

    if (isset($_GET['action'])) {
        if($_GET['action'] === 'getFormRegisterUser') {
            $controllerBase->render('Views/html/auth/register.php');
        }
        if($_GET['action'] === 'registerUser') {
            $controllerAuth->registerUser($_POST);
        }
        if($_GET['action'] === 'getFormLoginUser') {
            $controllerBase->render('Views/html/auth/login.php');
        }
        if($_GET['action'] === 'loginUser') {
            $controllerAuth->loginUser($_POST);
        }
        if($_GET['action'] === 'getDashboard') {
            $controllerBase->requireAuth();
            $controllerBase->render('Views/html/dashboard.php');
        }
    } else {
        $controllerBase->render('Views/html/home.php');
    }

    unset($_SESSION['errors']);
    unset($_SESSION['old']);
    unset($_SESSION['success']);
?>