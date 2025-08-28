<?php
require_once(__DIR__ . '/../config/database.php');

class Horario
{
    private $connection;
    private $tableName = "horarios";

    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->connect();
    }

    //Obtener todo el horario
    public function getAllHorarios()
    {
        $sqlQuery = "SELECT * FROM " . $this->tableName;
        $querStatement = $this->connection->prepare($sqlQuery);
        $querStatement->execute();
        $horariosList = $querStatement->fetchAll(PDO::FETCH_ASSOC);
        return $horariosList;
    }

    //obtener horario ID
    public function getHorarioById($id)
    {
        $sqlQuery = "SELECT * FROM " . $this->tableName . " WHERE id_horario = :id";
        $querStatement = $this->connection->prepare($sqlQuery);
        $querStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $querStatement->execute();
        return $querStatement->fetch(PDO::FETCH_ASSOC);
    }

    //Crear un horario
    public function createHorario($data)
    {
        $sqlQuery = "INSERT INTO " . $this->tableName . "
        (dia, hora_apertura, hora_cierre)
        VALUES (:dia, :hora_apertura, :hora_cierre)";

        $querStatement = $this->connection->prepare($sqlQuery);
        $querStatement->execute([
            ':dia' => $data['dia'],
            ':hora_apertura' => $data['hora_apertura'],
            ':hora_cierre' => $data['hora_cierre'],
        ]);
        return $this->connection->lastInsertId();
    }

    //Actualizar un horario
    public function updateHorario($id, $data)
    {
        $currentData = $this->getHorarioById($id);

        if (!$currentData) {
            return false;
        }

        $updateData = [
            ':dia' => $data['dia'] ?? $currentData['dia'],
            ':hora_apertura' => $data['hora_apertura'] ?? $currentData['hora_apertura'],
            ':hora_cierre' => $data['hora_cierre'] ?? $currentData['hora_cierre'],
            ':id' => $id
        ];

        $sqlQuery = "UPDATE " . $this->tableName . " SET
            dia = :dia,
            hora_apertura = :hora_apertura,
            hora_cierre = :hora_cierre
            WHERE id_horario = :id";

        $querStatement = $this->connection->prepare($sqlQuery);
        return $querStatement->execute($updateData);
    }

    //Eliminar un horario
    public function deleteHorario($id)
    {
        $sqlQuery = "DELETE FROM " . $this->tableName . " WHERE id_horario = :id";
        $querStatement = $this->connection->prepare($sqlQuery);
        $querStatement->bindParam(':id', $id, PDO::PARAM_INT);
        return $querStatement->execute();
    }
}
