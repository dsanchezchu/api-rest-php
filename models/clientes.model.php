<?php
require_once("conexion.php");

class clienteModel{
    static function index($tabla){
        $stmt=conexion::conectar()->prepare("SELECT*FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
        $stmt->null;
    }
}
?>