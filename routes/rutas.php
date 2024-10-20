<?php
$arrayRutas = explode("/", $_SERVER['REQUEST_URI']); //Captura la url

// echo "<pre>";
// print_r($arrayRutas);
// echo "<pre>";// En el indice 0 debe ir el localhost, lo cual no lo considera


if (count(array_filter($arrayRutas)) == 3) {
    echo $arrayRutas[3];
    echo "</br>";
    $json = array(
        "detalle" => "no encontrado"
    );
    echo json_encode($json, true);
    return;
} else {
    if (count(array_filter($arrayRutas)) == 4) {
        if (array_filter($arrayRutas)[4] == "cursos") {
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
                $cursos = new cursosController();
                $cursos->create();
            }
            else if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET"){
                $cursos = new cursosController();
                $cursos->index(); 
            }
        }

        if (array_filter($arrayRutas)[4] == "registro") {
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {
                $clientes = new clientesController();
                $clientes->index();
            }
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
                $clientes = new clientesController();
                $clientes->create();
            }
        }
    }
}
?>