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
}
