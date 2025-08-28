<?php

require_once(__DIR__ . '/../models/Mesas.php');

class MesasController
{
    private $mesasModel;

    public function __construct()
    {
        $this->mesasModel = new Mesas();
    }

    //GET /mesas o GET /mesas?id=1
    public function getMesas($id = null)
    {

        if ($id !== null) {
            $mesa = $this->mesasModel->getMesaById($id);

            if ($mesa) {
                echo json_encode([
                    "success" => true,
                    "data" => $mesa
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "message" => "Mesa no econtrada"
                ]);
            }
        } else {
            $allMesas = $this->mesasModel->getAllMesas();
            echo json_encode([
                "succes" => true,
                "data" => $allMesas
            ]);
        }
    }

    //POST /mesas - Crear una nueva mesa
    public function createMesa($data)
    {
        if (empty($data['numero_mesa']) || empty($data['nombre_mesa'])) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Numero de mesa y nombre requeridos"
            ]);
            return;
        }

        try {
            $id = $this->mesasModel->createMesa($data);

            echo json_encode([
                "success" => true,
                "message" => "Mesa creada exitosamente",
                "id" => $id
            ]);
        } catch (Exception $error) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "error al crear la mesa" . $error->getMessage()
            ]);
        }
    }

    //PUT /mesas - Actualizar una mesa
    public function updateMesa($id, $data)
    {
        $update = $this->mesasModel->updateMesa($id, $data);

        if ($update) {
            echo json_encode([
                "success" => true,
                "message" => "Mesa Actualizada"
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "success" => false,
                "message" => "Mesa no econtrada/Actualizada"
            ]);
        }
    }

    //DELETE /mesas?id=1 - Eliminar una mesa
    public function deleteMesa($id)
    {
        try {
            $mesaExiste = $this->mesasModel->getMesaById($id);

            if (!$mesaExiste) {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "message" => "Mesa no econtrada"
                ]);
                return;
            }

            $delete = $this->mesasModel->deleteMesa($id);

            if ($delete) {
                http_response_code(200);
                echo json_encode([
                    "success" => true,
                    "message" => "Mesa eliminada exitosamente"
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    "success" => false,
                    "message" => "Error al eliminar la mesa"
                ]);
            }
        } catch (Exception $error) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Error al eliminar mesa",
                "error" => $error->getMessage()
            ]);
        }
    }
}
