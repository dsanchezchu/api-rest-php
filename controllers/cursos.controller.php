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
            echo "<pre>";
            print_r($datosCursos);
            echo "</pre>";
        }
    }
?>