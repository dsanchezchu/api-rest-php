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
        
        public function create(){
            $json = array(
                "detalle" => "estas en la vista : create" 
            );
            echo json_encode($json, true);
            return;
        }
    }
?>