<?php 
class User {
    public function validateUser($data) {
        $conexion = new Conexion(); 
        $conexion->conectar();
        $sql = "SELECT * FROM users WHERE email = '$data[email]'";
        $conexion->query($sql);
        $result = $conexion->getResult();   
        if ($result->num_rows > 0) {
            return 1; // Usuario ya existe
        } 
        return 0; // Usuario no existe
    }
    public function registerUser($data) {
        $conexion = new Conexion(); 
        $conexion->conectar();
        $sql = "INSERT INTO users (document_type_id, document_number, name, last_name, phone, email, password) VALUES ('$data[document_type_id]', '$data[document_number]', '$data[name]', '$data[last_name]', '$data[phone]', '$data[email]', '$data[password]')";
        $conexion->query($sql);
        return $conexion->getFilasAfectadas(); // Retorna el número de filas afectadas por la consulta
    }
}
?>