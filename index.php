<?php
    session_start();
    require_once 'Controllers/controllerBase.php';
    require_once 'config/config.php';
    require_once 'Models/conexion.php';
    require_once 'Models/user.php';
    $controllerBase = new ControllerBase();

    if (isset($_GET['action'])) {
        if($_GET['action'] === 'getFormRegisterUser') {
            $controllerBase->verpaginaInicio('Views/html/auth/register.php');
        }
        if($_GET['action'] === 'registerUser') {
            $controllerBase->registerUser($_POST);
        }
        if($_GET['action'] === 'getFormLoginUser') {
            $controllerBase->verPaginaInicio('Views/html/auth/login.php');
        }
        if($_GET['action'] === 'loginUser') {
            $controllerBase->loginUser($_POST);
        }
        if($_GET['action'] === 'getDashboard') {
            $controllerBase->verPaginaInicio('Views/html/dashboard.php');
        }
    } else {
        $controllerBase->verPaginaInicio('Views/html/home.php');
    }

    unset($_SESSION['errors']);
    unset($_SESSION['old']);
    unset($_SESSION['success']);
?>