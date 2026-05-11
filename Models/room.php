<?php
class Room {

    public function getMaxPeople($roomId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();

        $stmt = $codigoConexion->prepare("SELECT max_people FROM rooms WHERE id = ?");
        $stmt->bind_param("i", $roomId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['max_people'];
        } else {
            return null; // No se encontró la habitación
        }
    }

    public function getAllCategories() {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();

        $query = "SELECT id, name FROM categories";
        $result = $codigoConexion->query($query);

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        return $categories;
    }

    public function getCategoryById($categoryId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();

        $stmt = $codigoConexion->prepare("SELECT id, name FROM categories WHERE id = ?");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Devuelve la categoría encontrada
        } else {
            return null; // No se encontró la categoría
        }
    }

    public function getGuestCountById($roomId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();

        $stmt = $codigoConexion->prepare("SELECT max_people FROM rooms WHERE id = ?");
        $stmt->bind_param("i", $roomId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['max_people'];
        } else {
            return null; // No se encontró la habitación
        }
    }

    public function getPriceById($roomId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();

        $stmt = $codigoConexion->prepare("SELECT price FROM rooms WHERE id = ?");
        $stmt->bind_param("i", $roomId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['price'];
        } else {
            return null; // No se encontró la habitación
        }
    }

    public function getAvailableRooms($categoryId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();

        $stmt = $codigoConexion->prepare(
        "SELECT 
        r.id AS id, 
        r.num_room AS number
        FROM rooms r
        LEFT JOIN bookings b
            ON r.id = b.room_id 
            AND b.status_id IN (1,2)
        WHERE b.room_id IS NULL
        AND r.category_id = ?"
        );

        $stmt->bind_param("i", $categoryId);
        $stmt->execute();

        $result = $stmt->get_result();

        $availableRooms = [];
        while ($row = $result->fetch_assoc()) {
            $availableRooms[] = $row;
        }
        return $availableRooms;
    }

    public function roomIdExists($roomId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();

        $stmt = $codigoConexion->prepare("SELECT * FROM rooms WHERE id = ?");
        $stmt->bind_param("i", $roomId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true; // La habitación existe
        } else {
            return false; // La habitación no existe
        }
    }

    public function  categoryExists($categoryId) {
        $conexion = new Conexion();
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();

        $stmt = $codigoConexion->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true; // La categoría existe
        } else {
            return false; // La categoría no existe
        }
    }
}