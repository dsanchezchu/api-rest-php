<?php
class cursosController
{
    public function index()
    {

        // VALIDAR LAS CREDENCIALES

        $clientes = clienteModel::index("clientes");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach($clientes as $key => $value){

                if(base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == base64_encode($value["id_cliente"].':'.$value["llave_secreta"])){
                    $cursos = cursoModel::index("cursos");
                    $json = array(
                        "status" => "200",
                        "total_Resgistros" => count($cursos),
                        "detalle" => $cursos
                    );
                    echo json_encode($json, true);
                    return;
                }
            }
           
        }
    }

    public function create($datosCursos)
    {
       
    }
}
?>