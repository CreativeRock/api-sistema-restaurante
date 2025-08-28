<?php
require_once(__DIR__ . '/../config/database.php');

class Client
{
    private $connection;
    private $tableName = "clientes";

    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->connect();
    }

    //Obtener todos los clientes
    public function getAllClientes()
    {
        $sqlQuery = "SELECT * FROM " . $this->tableName;
        $queryStatement = $this->connection->prepare($sqlQuery);
        $queryStatement->execute();
        $clientesList = $queryStatement->fetchAll(PDO::FETCH_ASSOC);
        return $clientesList;
    }

    //Obtener cliente id
    public function getClientById($id)
    {
        $sqlQuery = "SELECT * FROM " . $this->tableName . " WHERE id_cliente = :id";
        $queryStatement = $this->connection->prepare($sqlQuery);
        $queryStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $queryStatement->execute();
        return $queryStatement->fetch(PDO::FETCH_ASSOC);
    }

    //Crear cliente
    public function createClient($data)
    {
        $password = isset($data['password']) ? password_hash($data['password'], PASSWORD_DEFAULT) : null;

        $sqlQuery = "INSERT INTO " . $this->tableName . "
        (nombre, apellido, email, password, telefono, preferencias)
        VALUES (:nombre, :apellido, :email, :password, :telefono, :preferencias)";

        $queryStatement = $this->connection->prepare($sqlQuery);
        $queryStatement->execute([
            ':nombre' => $data['nombre'],
            ':apellido' => $data['apellido'],
            ':email' => $data['email'],
            ':password' => $password,
            ':telefono' => $data['telefono'],
            ':preferencias' => $data['preferencias'],
        ]);
        return $this->connection->lastInsertId();
    }

    //Actualizar cliente
    public function updateClient($id, $data)
    {
        $currentData = $this->getClientById($id);

        if (!$currentData) {
            return false;
        }

        $updateData = [
            ':nombre' => $data['nombre'] ?? $currentData['nombre'],
            ':apellido' => $data['apellido'] ?? $currentData['apellido'],
            ':email' => $data['email'] ?? $currentData['email'],
            ':telefono' => $data['telefono'] ?? $currentData['telefono'],
            ':preferencias' => $data['preferencias'] ?? $currentData['preferencias'],
            ':id' => $id
        ];

        // Manejar la contraseña por separado
        if (isset($data['password']) && !empty($data['password'])) {
            $updateData[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            $updateData[':password'] = $currentData['password']; // Mantener la contraseña actual
        }

        $sqlQuery = "UPDATE " . $this->tableName . " SET
            nombre = :nombre,
            apellido = :apellido,
            email = :email,
            password = :password,
            telefono = :telefono,
            preferencias = :preferencias
            WHERE id_cliente = :id";


        $queryStatement = $this->connection->prepare($sqlQuery);
        return $queryStatement->execute($updateData);
    }

    //Eliminar cliente
    public function deleteClient($id)
    {
        $sqlQuery = "DELETE FROM " . $this->tableName . " WHERE id_cliente = :id";
        $queryStatement = $this->connection->prepare($sqlQuery);
        $queryStatement->bindParam(':id', $id, PDO::PARAM_INT);
        return $queryStatement->execute();
    }
}
