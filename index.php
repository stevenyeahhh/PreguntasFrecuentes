<?php

ini_set('display_errors', '1');

//Configuración de la aplicación:
//-Información del servidor
//-Roles definidos en el sistema
//-Configuración de la base de datos. 
include 'config/config.php';

function __autoload($resource) {
//        echo ROOT . 'config' . DS . $resource . '.php';
    if (is_readable(ROOT . 'config' . DS . $resource . '.php')) {
        include ROOT . 'config' . DS . $resource . '.php';
    }
}

try {
    
    $r = new Request();
    
    
//    die("hola");
    $db = new Database();
    $singleton = Singleton::getInstance();
    $singleton->db = $db;
    $singleton->r = $r;
    new Boot($singleton->r);
} catch (Exception $e) {
//    var_dump($e);
    echo "Error 404";
}

//La forma en que se ejecuta un controlador es por url, el orden es [host]/[controlador]/[función del controlador][/ parómeotros]
//Para ver ejemplo de funcionamiento y funcionalidades bósicas del framework, ir a controllers/indexController
?>