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

    public function create()
    {
        $json = array(
            "detalle" => "estas en la vista registro"
        );
        echo json_encode($json, true);
        return;
    }
}
?>