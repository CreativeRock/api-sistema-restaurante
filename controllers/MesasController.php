<?php

require_once(__DIR__ . '/../models/Mesas.php');

class MesasController
{
    private $mesasModel;

    public function __construct()
    {
        $this->mesasModel = new Mesas();
    }
}
