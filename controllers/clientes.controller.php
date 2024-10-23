<?php
class clientesController
{
    public function index()
    {
        $cliente=clienteModel::index("clientes");
        $json = array(
            "detalle" => $cliente,
        );
        echo json_encode($json, true);
        return;
    }

    public function create($datos)
    {
        echo "<pre>";
        print_r($datos);
        echo "<pre>";
    }
}?>