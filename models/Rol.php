<?php
require_once(__DIR__ . '/../config/database.php');

class Rol
{
    private $connection;
    private $tableName = "roles";

    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->connect();
    }

    //Obtener todos los roles
    public function getAllRoles()
    {
        $sqlQuery = "SELECT * FROM " . $this->tableName;
        $queryStatement = $this->connection->prepare($sqlQuery);
        $queryStatement->execute();
        $rolesList = $queryStatement->fetchAll(PDO::FETCH_ASSOC);
        return $rolesList;
    }

    //Obtener Rol ID
    public function getRolById($id)
    {
        $sqlQuery = "SELECT * FROM " . $this->tableName . " WHERE id_rol = :id";
        $queryStatement = $this->connection->prepare($sqlQuery);
        $queryStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $queryStatement->execute();
        return $queryStatement->fetch(PDO::FETCH_ASSOC);
    }

    //Crear nuevo Rol
    public function createRol($data)
    {
        $sqlQuery = "INSERT INTO " . $this->tableName . "
        (nombre_rol, descripcion)
        VALUES (:nombre_rol, :descripcion)";

        $queryStatement = $this->connection->prepare($sqlQuery);
        $queryStatement->execute([
            ':nombre_rol' => $data['nombre_rol'],
            ':descripcion' => $data['descripcion']
        ]);
        return $this->connection->lastInsertId();
    }

    //Actualizar Rol
    public function updateRol($id, $data)
    {
        $currentData = $this->getRolById($id);

        if (!$currentData) {
            return false;
        }

        $updateData = [
            ':nombre_rol' => $data['nombre_rol'] ?? $currentData['nombre_rol'],
            ':descripcion' => $data['descripcion'] ?? $currentData['descripcion'],
            ':id' => $id
        ];

        $sqlQuery = "UPDATE " . $this->tableName . " SET
        nombre_rol = :nombre_rol,
        descripcion = :descripcion
        WHERE id_rol = :id";

        $queryStatement = $this->connection->prepare($sqlQuery);
        return $queryStatement->execute($updateData);
    }

    //Eliminar Rol
    public function deleteRol($id)
    {
        $sqlQuery = "DELETE FROM " . $this->tableName . " WHERE id_rol = :id";
        $queryStatement = $this->connection->prepare($sqlQuery);
        $queryStatement->bindParam(':id', $id, PDO::PARAM_INT);
        return $queryStatement->execute();
    }
}
