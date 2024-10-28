<?php
class clientesController
{
    public function index()
    {
        $cliente=clienteModel::index("clientes");
        $json = array(
            "detalle" => $cliente
        );
        echo json_encode($json, true);
        return;
    }

    public function create($datos)
    {
        // Validación de datos
        switch (true) {
            case (isset($datos['nombre']) && !preg_match('/^[a-zA-Z\s]+$/', $datos['nombre'])):
                $json = array(
                    "detalle" => "Error: El nombre solo puede contener letras y espacios"
                );
                echo json_encode($json, true);
                return;
            case (isset($datos['apellido']) && !preg_match('/^[a-zA-Z\s]+$/', $datos['apellido'])):
                $json = array(
                    "detalle" => "Error: El apellido solo puede contener letras y espacios"
                );
                echo json_encode($json, true);
                return;
            case (isset($datos['email']) && !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)):
                $json = array(
                    "detalle" => "Error: El formato del email no es válido"
                );
                echo json_encode($json, true);
                return;
            case (isset($datos['email']) && preg_match('/[^a-zA-Z0-9@._-]/', $datos['email'])):
                $json = array(
                    "detalle" => "Error: El email contiene caracteres especiales no permitidos"
                );
                echo json_encode($json, true);
                return;
            default:
                break;
        }

        // Validar email duplicado 
        $cliente = clienteModel::index("clientes");
        foreach($cliente as $key => $value){
            if($value['email'] == $datos['email']){
                $json = array(
                    "detalle" => "Error: El email " . $datos['email'] . " ya está registrado en el sistema"
                );
                echo json_encode($json, true);
                return;
            }
            if($value['apellido'] == $datos['apellido']){
                $json = array(
                    "detalle" => "Error: El apellido " . $datos['apellido'] . " ya está registrado en el sistema"
                );
                echo json_encode($json, true);
                return;
            }
            if($value['nombre'] == $datos['nombre']){
                $json = array(
                    "detalle" => "Error: El nombre " . $datos['nombre'] . " ya está registrado en el sistema"
                );
                echo json_encode($json, true);
                return;
            }
        }
    }
}
?>