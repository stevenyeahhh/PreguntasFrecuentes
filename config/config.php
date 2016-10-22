<?php
define('DS', DIRECTORY_SEPARATOR);
// define('DS', '/');
define('DEFAULT_CONTROLLER', 'Index');
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . DS );
define('DEFAULT_LAYOUT', 'default');
define('BASE', 'http://' . $_SERVER['SERVER_NAME'].'/' );
define("ROL_ADMINISTRADOR", "1");
define("ROL_AUTOR", "2");
define("ROL_APROBADOR", "3");
define("ROL_USUARIO", "4");
define("DB_ROUTE","mysql:host=localhost;dbname=frequestion");
define("DB_USER","frequestion_us"); 
define("DB_PASSWORD","frequestion?PW2207");
define("APP_NAME","FreQuestion");
//die('Hola11');
// define("DB_USER","root"); 
// define("DB_PASSWORD","root");  