<?php
    class controllerRutas{
        public function inicio(){
            header('Content-Type: application/json');
            include dirname(__FILE__) . '/../routes/rutas.php';
        }
    }
?>