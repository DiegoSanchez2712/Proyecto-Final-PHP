<?php
    session_start();
    require_once 'Controllers/controllerBase.php';
    require_once 'Controllers/controllerAuth.php';
    require_once 'Controllers/controllerDashboard.php';
    require_once 'Controllers/controllerRoom.php';
    require_once 'config/config.php';
    require_once 'Models/conexion.php';
    require_once 'Models/user.php';
    require_once 'Models/booking.php';
    require_once 'Models/room.php';
    require_once 'lib/fpdf186/fpdf.php';

    $controllerBase = new ControllerBase();
    $controllerAuth = new ControllerAuth();
    $controllerDashboard = new ControllerDashboard();

    if (isset($_GET['action'])) {
        if($_GET['action'] === 'getFormRegisterUser') {
            $controllerBase->render('html/auth/register');
        }
        if($_GET['action'] === 'registerUser') {
            $controllerAuth->registerUser($_POST);
        }
        if($_GET['action'] === 'getFormLoginUser') {
            $controllerBase->render('html/auth/login');
        }
        if($_GET['action'] === 'loginUser') {
            $controllerAuth->loginUser($_POST);
        }
        if($_GET['action'] === 'logoutUser') {
            session_destroy();
            $controllerBase->redirect(SITE_URL . 'index.php');
        }
        if($_GET['action'] === 'getDashboard') {
            $controllerBase->requireAuth();
            $controllerDashboard->index();
        }
        if($_GET['action'] === 'downloadSheet') {
            $controllerBase->requireAuth();
            $controllerDashboard->downloadSheet();
        }
        if($_GET['action'] === 'downloadPDF') {
            $controllerBase->requireAuth();
            $controllerDashboard->downloadPDF($_SESSION['user']['id'], $_GET['id']);
        }
        if($_GET['action'] === 'getFormCreateBooking') {
            $controllerBase->requireAuth();
            $controllerDashboard->getFormCreateBooking();
        }
        if($_GET['action'] === 'createBooking') {
            $controllerBase->requireAuth();
            $controllerDashboard->createBooking($_POST);
        }
        if($_GET['action'] === 'getAvailableRooms') {
            $controllerBase->requireAuthApi();
            $controllerRoom = new ControllerRoom();
            $controllerRoom->getAvailableRooms($_GET['categoryId'] ?? null);
        }
        if($_GET['action'] === 'getGuestCountAndPrice') {
            $controllerBase->requireAuthApi();
            $controllerRoom = new ControllerRoom();
            $controllerRoom->getGuestCountAndPrice($_GET['roomId'] ?? null);
        }
        if($_GET['action'] === 'getFormUpdateBooking') {
            $controllerBase->requireAuth();
            $controllerDashboard->getFormUpdateBooking($_GET['id'] ?? null);
        }
        if($_GET['action'] === 'updateBooking') {
            $controllerBase->requireAuth();
            $controllerDashboard->updateBooking($_POST);
        }
        if($_GET['action'] === 'cancelBooking') {
            $controllerBase->requireAuth();
            $controllerDashboard->cancelBooking($_GET['id'] ?? null);
        }
    } else {
        $controllerBase->render('html/home');
    }

    unset($_SESSION['errors']);
    unset($_SESSION['old']);
    unset($_SESSION['success']);
?>