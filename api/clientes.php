<?php
require_once(__DIR__ . '/../controllers/ClienteController.php');

try {
    $controller = new ClienteController();
    $method = $_SERVER['REQUEST_METHOD'];


    switch ($method) {
        case 'GET':
            $id = isset($_GET['id']) ? intval($_GET['id']) : null;
            $controller->getClients($id);
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(400);
                echo json_encode([
                    "success" => false,
                    "message" => "datos invalidos"
                ]);
                exit;
            }
            $controller->createClient($data);
            break;

        case 'PUT':
            $id = isset($_GET['id']) ? intval($_GET['id']) : null;

            if ($id === null || $id <= 0) {
                http_response_code(400);
                echo json_encode([
                    "success" => false,
                    "message" => "ID no valida o requerida"
                ]);
                exit;
            }

            $data = json_decode(file_get_contents('php://input'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(400);
                echo json_encode([
                    "success" => false,
                    "message" => "datos inválidos"
                ]);
                exit;
            }

            $controller->updateClient($id, $data);
            break;

        case 'DELETE':
            $id = isset($_GET['id']) ? intval($_GET['id']) : null;

            if ($id === null || $id <= 0) {
                http_response_code(400);
                echo json_encode([
                    "success" => false,
                    "message" => "ID no valida o requerida"
                ]);
                exit;
            }
            $controller->deleteClient($id);
            break;

        default:
            http_response_code(405);
            echo json_encode([
                "success" => false,
                "message" => "Método no permitido"
            ]);
            break;
    }
} catch (Exception $error) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Error interno",
        "error" => $error->getMessage()
    ]);
}
