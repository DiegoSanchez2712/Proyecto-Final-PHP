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
        echo "conectado";
    }

    public function desconectar() {
        $this->MySQLi->close();
    }

    public function query($sql) {
        $this->sql = $sql;
        $this->result = $this->MySQLi->query($this->sql);
        $this->filasAfectadas = $this->MySQLi->affected_rows;
    }

    public function getResult() {
        return $this->result;
    }

    public function getFilasAfectadas() {
        return $this->filasAfectadas;
    }
}
?>