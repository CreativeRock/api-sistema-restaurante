<?php
require_once(__DIR__ . '/../models/Cliente.php');

class ClienteController
{
    private $clientModel;

    public function __construct()
    {
        $this->clientModel = new Client();
    }

    //GET /clientes o GET /clientes?id=1
    public function getClients($id = null)
    {
        if ($id !== null) {
            $cliente = $this->clientModel->getClientById($id);

            if ($cliente) {
                echo json_encode([
                    "success" => true,
                    "data" => $cliente
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "message" => "Cliente no econtrado"
                ]);
            }
        } else {
            $allClients = $this->clientModel->getAllClientes();
            echo json_encode([
                "success" => true,
                "data" => $allClients
            ]);
        }
    }

    //POST /clientes - Crear un nuevo cliente
    public function createClient($data)
    {

        if (empty($data['nombre']) || empty($data['email'])) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Nombre y email requeridos"
            ]);
            return;
        }

        try {
            $id = $this->clientModel->createClient($data);

            echo json_encode([
                "success" => true,
                "message" => "Cliente Creado exitosamente",
                "id" => $id
            ]);
        } catch (Exception $error) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "error al crear cliente" . $error->getMessage()
            ]);
        }
    }

    //PUT /clientes - Actualizar un cliente
    public function updateClient($id, $data)
    {
        $update = $this->clientModel->updateClient($id, $data);
        if ($update) {
            echo json_encode([
                "success" => true,
                "message" => "Cliente Actualizado",
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "success" => false,
                "message" => "Cliente no econtrado/Actualizado"
            ]);
        }
    }

    //DELETE /clientes?id=1 - Eliminar un cliente
    public function deleteClient($id)
    {
        try {
            // Verificar si el cliente existe
            $clienteExiste = $this->clientModel->getClientById($id);
            if (!$clienteExiste) {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "message" => "Cliente no encontrado"
                ]);
                return;
            }

            $deleted = $this->clientModel->deleteClient($id);

            if ($deleted) {
                http_response_code(200);
                echo json_encode([
                    "success" => true,
                    "message" => "Cliente eliminado exitosamente"
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    "success" => false,
                    "message" => "Error al eliminar cliente"
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Error al eliminar cliente",
                "error" => $e->getMessage()
            ]);
        }
    }
}
