<?php
class database
{
    private $server = "localhost";
    private $db_name = "restaurante_reservas_pruebas_db";
    private $username = "root";
    private $password = "root";

    public function connect()
    {
        try {
            $connection = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->db_name, $this->username, $this->password);
            return $connection;
        } catch (PDOException $error) {
            echo "Error de conexión: " . $error->getMessage();
        }
    }
}
