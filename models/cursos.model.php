<?php
require_once("conexion.php");

class cursoModel{
    static function index($tabla){
        $stmt=conexion::conectar()->prepare("SELECT*FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->close();
        $stmt->null;
    }
}
?>