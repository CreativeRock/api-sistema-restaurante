<?php
require_once(__DIR__ . '/../models/Horarios.php');

class HorarioController
{
    private $horarioModel;

    public function __construct()
    {
        $this->horarioModel = new Horario();
    }

    //GET /horarios
    public function getHorarios($id = null)
    {
        if ($id !== null) {
            $horario = $this->horarioModel->getHorarioById($id);

            if ($horario) {
                echo json_encode([
                    "success" => true,
                    "data" => $horario
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "message" => "Horario no econtrado"
                ]);
            }
        } else {
            $allHorarios = $this->horarioModel->getAllHorarios();
            echo json_encode([
                "success" => true,
                "data" => $allHorarios
            ]);
        }
    }

    //POST /horarios - Crear un nuevo horario
    public function createHorario($data)
    {
        if (empty($data['dia']) || empty($data['hora_apertura']) || empty($data['hora_cierre'])) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Dia, Hora-Apertura, Hora-Cierre Requeridos"
            ]);
            return;
        }

        try {
            $id = $this->horarioModel->createHorario($data);

            echo json_encode([
                "success" => true,
                "message" => "Horario creado exitosamente",
                "id" => $id
            ]);
        } catch (Exception $error) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "error al cerar el horario" . $error->getMessage()
            ]);
        }
    }

    //PUT /horarios - Actualizar un horario
    public function updateHorario($id, $data)
    {
        $update = $this->horarioModel->updateHorario($id, $data);

        if ($update) {
            echo json_encode([
                "success" => true,
                "message" => "Horario Actualizado"
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "success" => false,
                "message" => "Horario no econtrado/Actualizado"
            ]);
        }
    }

    //DELETE /horarios?id=1 - Eliminar un horario
    public function deleteHorario($id)
    {
        try {
            $horarioExiste = $this->horarioModel->getHorarioById($id);

            if (!$horarioExiste) {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "message" => "Horario no encontrado"
                ]);
                return;
            }

            $delete = $this->horarioModel->deleteHorario($id);

            if ($delete) {
                http_response_code(200);
                echo json_encode([
                    "success" => true,
                    "message" => "Horario eliminado exitosamente"
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    "success" => false,
                    "message" => "Error al eliminar horario"
                ]);
            }
        } catch (Exception $error) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Error al eliminar horario",
                "error" => $error->getMessage()
            ]);
        }
    }
}
