<?php
// eL .htaccess hace que recaiga todo sobre el index.php
//  el index requiere  una ruta -> la ruta requiere un controller y el controller esta instanciado en index
    require_once "controllers/rutas.controller.php";
    require_once "controllers/cursos.controller.php";
    require_once "controllers/clientes.controller.php";
    require_once "models/cursos.model.php";
    require_once "models/clientes.model.php";
    
    $routes = new controllerRutas();
    $routes->inicio();
?>