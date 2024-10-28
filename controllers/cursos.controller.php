<?php
    class cursosController{
        public function index(){
            $cursos=cursoModel::index("cursos");
            $json = array(
                "detalle" => $cursos,
            );
            echo json_encode($json, true);
            return;
        }
        
        public function create($datosCursos){
            switch (true) {
                case (isset($datosCursos['titulo']) && preg_match('/[^a-zA-Z\s]/', $datosCursos['titulo'])):
                    $json = array(
                        "detalle" => "El titulo contiene caracteres especiales no permitidos"
                    );
                    echo json_encode($json, true);
                    return;
                default:
                    break;
            }
          

        }
    }
?>