<?php

abstract class Controller
{
    protected $_view;
    
    public function __construct()
    {
        $this->_view = new View(new Request());
    }
    
    abstract public function index();
    
    protected function loadModel($modelo)
    {
        $modelo = ucfirst($modelo) . 'Model';
        $rutaModelo = ROOT . 'models' . DS . $modelo . '.php';
        
        if (is_readable($rutaModelo))
        {
            require_once $rutaModelo;
            $modelo = new $modelo;
            return $modelo;
        }
        else
        {
            throw new Exception('<pre>No se encontró el modelo #0 '.$modelo);
        }
    }
    
    protected function loadLibrary($libreria)
    {
        $rutaLibreria = ROOT . 'libs' . DS . $libreria . '.php';
        if (is_readable($rutaLibreria)) 
        {
            require_once $rutaLibreria;
        }
        else
        {
            throw new Exception('Error al leer la librería');
        }
    }
    
    protected function getTexto($clave)
    {
        if (isset($_POST[$clave]) && !empty($_POST[$clave]))
        {
            $_POST[$clave] = htmlspecialchars($_POST[$clave], ENT_QUOTES);
            return $_POST[$clave];
        }
            
        return '';
    }
    
    protected function getInt($clave)
    {
        if (isset($_POST[$clave]) && !empty($_POST[$clave]))
        {
            // Uso de filter_input() para validar enteros
            return filter_input(INPUT_POST, $clave, FILTER_VALIDATE_INT) ?: 0;
        }
            
        return 0;
    }
    
    protected function redireccionar($ruta = false)
    {
        $url = $ruta ? BASE_URL . $ruta : BASE_URL;
        header('Location: ' . $url);
        exit;
    }
    
    protected function filterInt($int)
    {
        return (int) $int;
    }
    
    protected function filtrarPOST($clave)
    {
        return isset($_POST[$clave]) ? $_POST[$clave] : null;
    }
    
    protected function getSql($clave)
    {
        if (isset($_POST[$clave]) && !empty($_POST[$clave])) 
        {
            $_POST[$clave] = strip_tags($_POST[$clave]);
            
            // Código obsoleto: get_magic_quotes_gpc() y mysql_escape_string()
            // get_magic_quotes_gpc() y mysql_escape_string() están obsoletos y se eliminan.
            // Se deben usar consultas preparadas con PDO o MySQLi para evitar inyecciones SQL.

            return trim($_POST[$clave]);
        }
        return '';
    }
    
    protected function getAlphaNum($clave)
    {
        if (isset($_POST[$clave]) && !empty($_POST[$clave]))
        {
            return trim(preg_replace('/[^A-Z0-9_]/i', '', $_POST[$clave]));
        }
        return '';
    }
    
    public function validarEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
