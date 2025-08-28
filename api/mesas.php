<?php
require_once(__DIR__ . '/../controllers/MesasController.php');

try {
    $controller = new MesasController();
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            $id = isset($_GET['id']) ? intval($_GET['id']) : null;
            $controller->getMesas();
            break;

        default:
            # code...
            break;
    }
} catch (Exception $error) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Error interno de servidor",
        "Error" => $error->getMessage()
    ]);
}
