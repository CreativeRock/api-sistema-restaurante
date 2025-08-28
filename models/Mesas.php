<?php
require_once(__DIR__ . '/../config/database.php');

class Mesas
{
    private $connection;
    private $tableName = "mesas";



    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->connect();
    }


    //Obtener todas las mesas
    public function getAllMesas()
    {
        $sqlQuery = "SELECT * FROM " . $this->tableName;
        $queryStatement = $this->connection->prepare($sqlQuery);
        $queryStatement->execute();
        $mesasList = $queryStatement->fetchAll(PDO::FETCH_ASSOC);
        return $mesasList;
    }

    //Obtener mesa ID
    public function getMesaById($id)
    {
        $sqlQuery = "SELECT * FROM " . $this->tableName . " WHERE id_mesa = :id";
        $queryStatement = $this->connection->prepare($sqlQuery);
        $queryStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $queryStatement->execute();
        return $queryStatement->fetch(PDO::FETCH_ASSOC);
    }

    //Crear mesa
    public function createMesa($data)
    {
        $sqlQuery = "INSERT INTO " . $this->tableName . "
        mesas (numero_mesa, nombre_mesa, caracteristicas, capacidad, ubicacion, estado, tipo)
        VALUES (':numero_mesa', ':nombre_mesa', ':caracteristicas', ':capacidad', ':ubicacion', ':estado', ':tipo')";

        $queryStatement = $this->connection->prepare($sqlQuery);
        $queryStatement->execute([
            ':numero_mesa' => $data['numero_mesa'],
            ':nombre_mesa' => $data['nombre_mesa'],
            ':caracteristicas' => $data['caracteristicas'],
            ':capacidad' => $data['capacidad'],
            ':ubicacion' => $data['ubicacion'],
            ':estado' => $data['estado'],
            ':tipo' => $data['tipo']
        ]);
        return $this->connection->lastInsertId();
    }
}
