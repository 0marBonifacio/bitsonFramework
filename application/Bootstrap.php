<?php

class Bootstrap
{
    public static function run(Request $peticion)
    {
        $controller = $peticion->getControlador() . 'Controller';
        $rutaControlador = ROOT . 'controllers' . DS . $controller . '.php';
        $metodo = $peticion->getMetodo();
        $argumentos = $peticion->getArgumentos();
        
        if (is_readable($rutaControlador)) 
        {
            require_once $rutaControlador;
            
            $controller = new $controller;
            
            // Se llama al metodo del controlador
            if (is_callable([$controller, $metodo])) 
            {
                $metodo = $peticion->getMetodo();
            }
            else 
            {
                $metodo = 'index';
            }
            
            // Se llama a los argumentos del metodo
            if (isset($argumentos)) 
            {
                call_user_func_array([$controller, $metodo], $argumentos);
            }
            else 
            {
                call_user_func([$controller, $metodo]);
            }
        }
        else 
        {
            // En un entorno de producción, se debería registrar el error en un archivo log
            throw new Exception('Controlador no encontrado');
        }
    }
}
