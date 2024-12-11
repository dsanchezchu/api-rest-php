<?php
$arrayRutas = explode("/", $_SERVER['REQUEST_URI']); //Captura la url

// echo "<pre>";
// print_r($arrayRutas);
// echo "<pre>";// En el indice 0 debe ir el localhost, lo cual no lo considera


if (count(array_filter($arrayRutas)) == 2) {
    echo $arrayRutas[2];
    echo "</br>";
    $json = array(
        "detalle" => "no encontrado"
    );
    echo json_encode($json, true);
    return;
} else {
    if (count(array_filter($arrayRutas)) == 3) {
        if (array_filter($arrayRutas)[3] == "cursos") {
            if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST" ){

           
                /*=============================================
                  Capturar datos
                  =============================================*/

           $datos = array( "titulo"=>$_POST["titulo"],
                          "descripcion"=>$_POST["descripcion"],
                          "instructor"=>$_POST["instructor"],
                          "imagen"=>$_POST["imagen"],
                          "precio"=>$_POST["precio"]);

                        //  echo "<pre>"; print_r($datos); echo "<pre>";

              $cursos=new cursosController();
              $cursos->create($datos);

          }

          else if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET" ){
              $cursos=new cursosController();
              $cursos->index(null);

          }
        }

        if (array_filter($arrayRutas)[3] == "registro") {
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {
                $clientes = new clientesController();
                $clientes->index();
            }
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
                $datos= array("nombre" => $_POST["nombre"],
                "apellido" => $_POST["apellido"],
                "email" => $_POST["email"]);

                $clientes = new clientesController();
                $clientes->create($datos);
            }
        }
    }
}
?>