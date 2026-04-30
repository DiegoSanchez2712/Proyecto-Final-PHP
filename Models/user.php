<?php 
class User {
    public function getUserById($id) {
        $conexion = new Conexion(); 
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();

        $stmt = $codigoConexion->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $consulta = $result->fetch_assoc();
            return $consulta;
        } else {
            return null;
        }
    }

    public function getUserByEmail($email) {
        $conexion = new Conexion(); 
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();

        $stmt = $codigoConexion->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $consulta = $result->fetch_assoc();
            return $consulta; // Retorna los datos del usuario
        } else {
            return null;
        }
    }

    public function emailExists($email) {
        $conexion = new Conexion(); 
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();

        $stmt = $codigoConexion->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true; // El email ya existe
        } else {
            return false; // El email no existe
        }
    }

    public function documentNumberExists($document_number) {
        $conexion = new Conexion(); 
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();

        $stmt = $codigoConexion->prepare("SELECT * FROM users WHERE document_number = ?");
        $stmt->bind_param("s", $document_number);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true; // El número de documento ya existe
        } else {
            return false; // El número de documento no existe
        }
    }

    public function createUser($data) {
        $conexion = new Conexion(); 
        $conexion->conectar();
        $codigoConexion = $conexion->getMySQLi();
        $stmt = $codigoConexion->prepare("INSERT INTO users (document_type_id, document_number, name, last_name, phone, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "iisssss",
            $data['document_type_id'],
            $data['document_number'],
            $data['name'],
            $data['last_name'],
            $data['phone'],
            $data['email'],
            $data['password']
        );
        if ($stmt->execute()) {
            return true; // Los datos se insertaron correctamente
        } else {
            return false; // Error al ejecutar la consulta
        }
    }
}
?>