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
            return true; // Los datos se insertaron correctamente
        } else {
            return false; // Error al ejecutar la consulta
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

    public function getUserBookingWithDetailsById($userId, $bookingId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();
        $stmt = $codigoConexion->prepare("
            SELECT 
                b.id AS ID_de_reserva,
                c.name AS Categoria_de_habitacion,
                r.num_room AS Numero_de_habitacion, 
                b.start_date AS Fecha_de_empiezo, 
                b.end_date AS Fecha_de_final, 
                b.guest_count AS Total_de_visitantes, 
                r.max_people AS Maximo_de_visitantes,
                sb.name AS Estado_de_reserva, 
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

    function bookingExists($roomId, $startDate, $endDate) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();

        $stmt = $codigoConexion->prepare(
            "SELECT *
            FROM bookings
            WHERE room_id = ?
            AND status_id IN (1,2)
            AND (
                start_date < ?
                AND end_date > ?
            );"
        );

        $stmt->bind_param("iss", $roomId, $endDate, $startDate);
        $stmt->execute();

        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return true; // Existe una reserva para esa habitación en las fechas dadas
        } else {
            return false; // No existe una reserva para esa habitación en las fechas dadas
        }

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