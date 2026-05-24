<?php
class Booking {

    public function createBooking($userId, $data) {

        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();
        $stmt = $codigoConexion->prepare("INSERT INTO bookings (
        user_id, 
        room_id, 
        start_date, 
        end_date, 
        guest_count, 
        total_price, 
        payment_method_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "iissidi", 
            $userId,
            $data['room_id'], 
            $data['start_date'], 
            $data['end_date'], 
            $data['guest_count'], 
            $data['total_price'],
            $data['payment_method_id']
        );
        
        if ($stmt->execute()) {
            return $codigoConexion->insert_id;
        } else {
            return false;
        }
    }

    public function updateBooking($userId, $data) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();
        $stmt = $codigoConexion->prepare("
        UPDATE bookings
        SET
            user_id = ?,
            room_id = ?,
            start_date = ?,
            end_date = ?,
            guest_count = ?,
            total_price = ?,
            payment_method_id = ?
        WHERE id = ?;
        ");

        $stmt->bind_param(
            "iissiiii",
            $userId,
            $data['room_id'],
            $data['start_date'],
            $data['end_date'],
            $data['guest_count'],
            $data['total_price'],
            $data['payment_method_id'],
            $data['booking_id']
        );
        $stmt->get_result();

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateBookingStatus($bookingId, $statusId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();
        $stmt = $codigoConexion->prepare("
        UPDATE bookings
        SET 
            status_id = ?
        WHERE id = ?
        ");

        $stmt->bind_param("ii", $statusId, $bookingId ); 
        $stmt->get_result();

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserBookingsWithDetails($userId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();
        $stmt = $codigoConexion->prepare("
            SELECT 
                b.id,
                r.num_room AS Numero_de_habitacion, 
                b.start_date AS Fecha_de_empiezo, 
                b.end_date AS Fecha_de_final, 
                b.guest_count AS Total_de_visitantes, 
                sb.name AS Estado_de_reserva, 
                b.total_price AS Total_a_pagar
            FROM users u 
            JOIN bookings b ON b.user_id = u.id
            JOIN rooms r ON b.room_id = r.id
            JOIN status_bookings sb ON b.status_id = sb.id
            WHERE u.id = ?
        ");

        $stmt->bind_param("i", $userId); 
        $stmt->execute();

        $result = $stmt->get_result();

        $bookings = [];
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }

        return $bookings;
    }

    public function getBookingById($userId, $bookingId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();
        $stmt = $codigoConexion->prepare("
            SELECT 
                b.id AS ID_de_reserva,
                c.id AS ID_de_categoria,
                c.name AS Categoria_de_habitacion,
                r.id AS ID_de_habitacion,
                r.num_room AS Numero_de_habitacion, 
                b.start_date AS Fecha_de_empiezo, 
                b.end_date AS Fecha_de_final, 
                b.guest_count AS Total_de_visitantes, 
                r.max_people AS Maximo_de_visitantes,
                sb.name AS Estado_de_reserva, 
                b.payment_method_id AS ID_de_metodo_de_pago,
                b.total_price AS Total_a_pagar
            FROM users u 
            JOIN bookings b ON b.user_id = u.id
            JOIN rooms r ON b.room_id = r.id
            JOIN status_bookings sb ON b.status_id = sb.id
            JOIN categories c ON r.category_id = c.id
            WHERE u.id = ? AND b.id = ?
        ");

        $stmt->bind_param("ii", $userId, $bookingId); 
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Devuelve la reserva encontrada
        } else {
            return null; // No se encontró la reserva
        }
    }

    public function getBookingDetails($userId, $bookingId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();
        $stmt = $codigoConexion->prepare("
            SELECT 
                b.id AS Reserva,
                c.name AS Categoria_de_habitacion,
                r.num_room AS Numero_de_habitacion,
                b.start_date AS Fecha_de_inicio,
                b.end_date AS Fecha_de_final,
                b.guest_count AS Numero_de_huespedes,
                sb.name AS Estado_de_reserva,
                pm.name AS Metodo_de_pago,
                b.total_price AS Total_a_pagar
            FROM users u
            JOIN bookings b ON b.user_id = u.id
            JOIN rooms r ON b.room_id = r.id
            JOIN categories c ON r.category_id = c.id
            JOIN status_bookings sb ON b.status_id = sb.id
            JOIN payment_methods pm ON b.payment_method_id = pm.id
            WHERE u.id = ? 
            AND b.id = ?
        ");

        $stmt->bind_param("ii", $userId, $bookingId); 
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Devuelve la reserva encontrada
        } else {
            return null; // No se encontró la reserva
        }
    }
    
    public function getPrice($roomId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();

        $stmt = $codigoConexion->prepare("SELECT price FROM rooms WHERE id = ?");
        $stmt->bind_param("i", $roomId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $room = $result->fetch_assoc();
            return $room['price']; // Devuelve el precio de la habitación
        } else {
            return null; // No se encontró la habitación
        }
    }

    public function getNumRoom($roomId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();
        $stmt = $codigoConexion->prepare("SELECT num_room FROM rooms WHERE id = ?");

        $stmt->bind_param("i", $roomId); 
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $room = $result->fetch_assoc();
            return $room['num_room']; // Devuelve el numero de habitacion
        } else {
            return null; // No se encontró la habitación
        }
    }

    public function getpaymentMethod($paymentMethodId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();
        $stmt = $codigoConexion->prepare("SELECT name FROM payment_methods WHERE id = ?");

        $stmt->bind_param("i", $paymentMethodId); 
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $paymentMethod = $result->fetch_assoc();
            return $paymentMethod['name']; // Devuelve el metodo de pago
        } else {
            return null; // No se encontró el metodo de pago
        }
    }

    public function getStatus($statusId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();
        $stmt = $codigoConexion->prepare("SELECT name FROM status_bookings WHERE id = ?");

        $stmt->bind_param("i", $statusId); 
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $status = $result->fetch_assoc();
            return $status['name']; // Devuelve el estado de la reserva
        } else {
            return null; // No se encontró el estado de la reserva
        }
    }

    function getStatusByName($name) {
    $conexion = new Conexion();
    $conexion->conectar();

    $codigoConexion = $conexion->getMySQLi();

    $stmt = $codigoConexion->prepare("
        SELECT id 
        FROM status_bookings 
        WHERE name = ? 
        LIMIT 1
    ");

    $stmt->bind_param("s", $name);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id'];
    }

    return null;
}

    public function getAllPaymentMethods() {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();

        $query = "SELECT id, name FROM payment_methods";
        $result = $codigoConexion->query($query);

        $paymentMethods = [];
        while ($row = $result->fetch_assoc()) {
            $paymentMethods[] = $row;
        }
        return $paymentMethods;
    }

    function bookingExists($roomId, $startDate, $endDate, $bookingId = null) {

    $conexion = new Conexion();
    $conexion->conectar();
    $codigoConexion = $conexion->getMySQLi();

    $query = "
        SELECT *
        FROM bookings
        WHERE room_id = ?
        AND status_id IN (1,2)
        AND (
            start_date < ?
            AND end_date > ?
        )
    ";

    if ($bookingId !== null) {
        $query .= " AND id != ?";
    }

    $stmt = $codigoConexion->prepare($query);

    if ($bookingId !== null) {
        $stmt->bind_param("issi", $roomId, $endDate, $startDate, $bookingId);
    } else {
        $stmt->bind_param("iss", $roomId, $endDate, $startDate);
    }

    $stmt->execute();

    $result = $stmt->get_result();

    return $result->num_rows > 0;
}

    function calculateTotalPrice($roomId, $startDate, $endDate) {
        $pricePerNight = $this->getPrice($roomId);
        if ($pricePerNight !== null) {
            $start = new DateTime($startDate);
            $end = new DateTime($endDate);
            $nights = $start->diff($end)->days;
            return $pricePerNight * $nights;
        }
        return null;
    }
}
?>