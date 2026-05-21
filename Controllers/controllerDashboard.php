<?php
require_once 'Controllers/controllerBase.php';
require_once 'lib/fpdf186/fpdf.php';
class ControllerDashboard extends ControllerBase {

    public function index() {
        $booking = new Booking();
        $reservas = $booking->getUserBookingsWithDetails($_SESSION['user']['id']);
        $this->render('html/dashboard/dashboard', ['bookings' => $reservas]);
    }

    public function getFormCreateBooking() {
        $room = new Room();
        $booking = new Booking();
        $categories = $room->getAllCategories();
        $paymentMethods = $booking->getAllPaymentMethods();
        $this->render('html/dashboard/booking/createBooking', ['categories' => $categories, 'paymentMethods' => $paymentMethods]);
    }

    public function getFormUpdateBooking($bookingId) {
        $booking = new Booking();
        $reserva = $booking->getUserBookingWithDetailsById($_SESSION['user']['id'], $bookingId);
        $paymentMethods = $booking->getAllPaymentMethods();
        if (!$reserva) {
            $_SESSION['errors'] = ['general' => 'Reserva no encontrada'];
            $this->redirect(SITE_URL . 'index.php?action=getDashboard');
            exit;
        }
        $this->render('html/dashboard/booking/editBooking', ['booking' => $reserva, 'paymentMethods' => $paymentMethods]);
    }

    public function cancelBooking($bookingId) {

        if (!$bookingId) {
            die("ID inválido");
        }

        $booking = new Booking();

        $statusId = $booking->getStatusByName("Cancelada");

        if (!$statusId) {
            die("Estado 'Cancelada' no existe");
        }

        $booking->updateBookingStatus($bookingId, $statusId);

        $this->index();
    }

    public function downloadPDF($userId, $bookingId) {
        $booking = new Booking();
        $reportData = $booking->getBookingDetailsForPdf($userId, $bookingId);

        if ($reportData){
            $this->render("html/dashboard/reports/downloadBooking", ['booking' => $reportData]);
        }
        else {
            $this->index();
        }
    }

    public function validateBookingData($datos) {
    $errores = [];

    if (empty($datos['category_id'])) {
        $errores['category_id'][] = 'El campo categoría es obligatorio.';
    }

    if (empty($datos['room_id'])) {
        $errores['room_id'][] = 'El campo habitación es obligatorio.';
    }

    $startDate = $datos['start_date'] ?? null;

    if (!empty($startDate)) {
        $start = DateTime::createFromFormat('Y-m-d', $startDate);

        if (!$start || $start->format('Y-m-d') !== $startDate) {
            $errores['start_date'][] = 'La fecha de inicio no es válida.';
        }
    } else {
        $errores['start_date'][] = 'El campo fecha de inicio es obligatorio.';
    }

    $endDate = $datos['end_date'] ?? null;

    if (!empty($endDate)) {
        $end = DateTime::createFromFormat('Y-m-d', $endDate);

        if (!$end || $end->format('Y-m-d') !== $endDate) {
            $errores['end_date'][] = 'La fecha de fin no es válida.';
        }
    } else {
        $errores['end_date'][] = 'El campo fecha de fin es obligatorio.';
    }

    if (empty($errores['start_date']) && empty($errores['end_date'])) {

        $start = DateTime::createFromFormat('Y-m-d', $startDate);
        $end = DateTime::createFromFormat('Y-m-d', $endDate);

        if ($start && $end) {
            $start->setTime(0, 0, 0);
            $end->setTime(0, 0, 0);

            if ($start >= $end) {
                $errores['date_range'][] = 'La fecha final debe ser mayor a la inicial';
            }
        }
    }

    return $errores;
}

    private function validateBookingDatabaseRules($datos, $booking, $room) {
        $errores = [];
    
        if ($booking->bookingExists($datos['room_id'], $datos['start_date'], $datos['end_date'], $datos['booking_id'])) {
            $errores['general'][] = 'La habitación no está disponible en las fechas seleccionadas.';
        } 

        if ($room->categoryExists($datos['category_id']) === false) {
            $errores['category_id'][] = 'La categoría seleccionada no existe.';
        }

        if ($room->roomIdExists($datos['room_id']) === false) {
            $errores['room_id'][] = 'La habitación seleccionada no existe.';
        }

        if ($room->getMaxPeople($datos['room_id']) + 2 < $datos['guest_count']) {
            $errores['guest_count'][] = 'El número de visitantes excede la capacidad de la habitación.';
        }

        
        return $errores;
    }

    public function createBooking($datos) {
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
        unset($_SESSION['success']);

        $errores = $this->validateBookingData($datos);

        $booking = new Booking();
        $room = new Room();

        if (empty($errores)) {
            $errores = $this->validateBookingDatabaseRules($datos, $booking, $room);
        }
        
        if (!empty($errores)) {
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            $this->redirect(SITE_URL . 'index.php?action=getFormCreateBooking');
        } 

        $datos['total_price'] = $booking->calculateTotalPrice($datos['room_id'], $datos['start_date'], $datos['end_date']);

        $resultado = $booking->createBooking($_SESSION['user']['id'], $datos);
        if ($resultado === true) {
            $_SESSION['success'] = 'Reserva creada exitosamente';
            $this->redirect(SITE_URL . 'index.php?action=getDashboard');
        } else {
            $_SESSION['errors'] = ['general' => 'Error al crear la reserva'];
            $_SESSION['old'] = $datos;
            
            $this->redirect(SITE_URL . 'index.php?action=getFormCreateBooking');
        }

    }

    public function UpdateBooking($datos) {
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
        unset($_SESSION['success']);

        $errores = $this->validateBookingData($datos);

        $booking = new Booking();
        $room = new Room();

        if (empty($errores)) {
            $errores = $this->validateBookingDatabaseRules($datos, $booking, $room);
        }
        
        if (!empty($errores)) {
            $_SESSION['errors'] = $errores;
            $_SESSION['old'] = $datos;
            $this->redirect(SITE_URL . 'index.php?action=getFormUpdateBooking&id='. $datos['booking_id']);
        } 

        $datos['total_price'] = $booking->calculateTotalPrice($datos['room_id'], $datos['start_date'], $datos['end_date']);

        $resultado = $booking->updateBooking($_SESSION['user']['id'], $datos);
        if ($resultado === true) {
            $_SESSION['success'] = 'Reserva editada exitosamente';
            $this->redirect(SITE_URL . 'index.php?action=getDashboard');

        } else {
            $_SESSION['errors'] = ['general' => 'Error al editar la reserva'];
            $_SESSION['old'] = $datos;
            
            $this->redirect(SITE_URL . 'index.php?action=getFormUpdateBooking&id='. $datos['booking_id']);
        }

    }

}