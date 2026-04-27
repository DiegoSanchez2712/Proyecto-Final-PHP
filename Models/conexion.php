<?php
class Conexion {
    private $MySQLi;
    private $sql;
    private $result;
    private $filasAfectadas;

    public function conectar() {
        $host = "localhost";
        $db_name = "hotel_fourseasons";
        $username = "root";
        $password = "";

        $this->MySQLi = new mysqli($host, $username, $password, $db_name);

        if ($this->MySQLi->connect_error) {
            die("Error de conexión: " . $this->MySQLi->connect_error);
        }
    }

    public function desconectar() {
        $this->MySQLi->close();
    }

    public function query($sql) {
        $this->sql = $sql;
        $this->result = $this->MySQLi->query($this->sql);
        $this->filasAfectadas = $this->MySQLi->affected_rows;
    }

    public function getMySQLi() {
        return $this->MySQLi;
    }

    public function getResult() {
        return $this->result;
    }

    public function getFilasAfectadas() {
        return $this->filasAfectadas;
    }
}
?>