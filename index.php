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
    } else {
        $controllerBase->verPaginaInicio('Views/html/home.php');
    }

?>