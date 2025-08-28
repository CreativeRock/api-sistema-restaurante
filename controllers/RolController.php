<?php
require_once(__DIR__ . '/../models/Rol.php');

class RolController
{
    private $rolModel;

    public function __construct()
    {
        $this->rolModel = new Rol();
    }

    //GET /roles o GET /roles?id=1
    public function getRoles($id = null)
    {
        if ($id !== null) {
            $rol = $this->rolModel->getRolById($id);

            if ($rol) {
                echo json_encode([
                    "success" => true,
                    "data" => $rol
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "message" => "Rol no econtrado"
                ]);
            }
        } else {
            $allRoles = $this->rolModel->getAllRoles();
            echo json_encode([
                "success" => true,
                "data" => $allRoles
            ]);
        }
    }

    //POST /roles - crear un nuevo rol
    public function createRol($data)
    {
        if (empty($data['nombre_rol']) || empty($data['descripcion'])) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "NombreRol y Descripcion requeridos"
            ]);
            return;
        }

        try {
            $id = $this->rolModel->createRol($data);

            echo json_encode([
                "success" => true,
                "message" => "Rol creado exitosamente",
                "id" => $id
            ]);
        } catch (Exception $error) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Error al crear el Rol" . $error->getMessage()
            ]);
        }
    }

    //PUT /roles - Actualizar un rol
    public function updateRol($id, $data)
    {
        $update = $this->rolModel->updateRol($id, $data);

        if ($update) {
            echo json_encode([
                "success" => true,
                "message" => "Rol Actualizado"
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "success" => false,
                "message" => "Rol no Encontrado/Actualizado"
            ]);
        }
    }

    //DELETE /roles?id=1 - Eliminar un rol
    public function deleteRol($id)
    {
        try {
            $rolExiste = $this->rolModel->getRolById($id);

            if (!$rolExiste) {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "message" => "Rol no econtrado"
                ]);
                return;
            }

            $delete = $this->rolModel->deleteRol($id);

            if ($delete) {
                http_response_code(200);
                echo json_encode([
                    "success" => true,
                    "message" => "Rol eliminado exitosamente"
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    "success" => false,
                    "message" => "Error al eliminar el Rol"
                ]);
            }
        } catch (Exception $error) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Error al eliminar el Rol",
                "error" => $error->getMessage()
            ]);
        }
    }
}
