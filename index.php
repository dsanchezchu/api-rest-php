<?php
// eL .htaccess hace que recaiga todo sobre el index.php
//  el index requiere  una ruta -> la ruta requiere un controller y el controller esta instanciado en index
    require_once "controllers/rutas.controller.php";
    $routes = new controllerRutas();
    $routes->inicio();
?>