<?php

// Imprime un ID único para utilizarlo como HASH_KEY
// echo uniqid(); exit;

// Habilita la visualización de errores (útil en desarrollo; deshabilitar en producción)
ini_set('display_errors', 1);
error_reporting(E_ALL); // Asegura que todos los errores se muestren

// Definiciones de directorios
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('APP_PATH', ROOT . 'application' . DS);

try {
    // Carga los archivos principales
    require_once APP_PATH . 'Autoload.php';
    require_once APP_PATH . 'Config.php';
    
    // Inicia la sesión
    Session::start();
    
    // Configura el Registro (Registry)
    $registry = Registry::getInstancia();
    $registry->_request = new Request();
    
    // Conecta a la base de datos
    $registry->_db = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHAR);
    
    // Carga el sistema de control de acceso (ACL)
    $registry->_acl = new ACL();

    // Ejecuta la aplicación
    Bootstrap::run($registry->_request);
    
} catch (Exception $e) {
    // Muestra el error capturado (idealmente, registra el error en un archivo de log)
    echo '<pre>';
    echo $e;
    echo '</pre>';
}
