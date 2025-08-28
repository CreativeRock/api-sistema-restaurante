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
}
