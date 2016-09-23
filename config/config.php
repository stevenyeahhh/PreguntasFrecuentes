<?php
define('DS', DIRECTORY_SEPARATOR);
// define('DS', '/');
define('DEFAULT_CONTROLLER', 'Index');
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . DS );
define('DEFAULT_LAYOUT', 'default');
define('BASE', 'http://' . $_SERVER['SERVER_NAME'].'/' );
define("ROL_ADMINISTRADOR", "1");
define("ROL_USUARIO_SECUNDARIO", "2");
define("DB_ROUTE","mysql:host=localhost;dbname=preguntas_fq_db");
define("DB_USER","root"); 
define("DB_PASSWORD","");
// define("DB_USER","root"); 
// define("DB_PASSWORD","root");  