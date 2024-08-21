<?php

class Session
{
    public static function start()
    {
        session_start();
    }
    
    public static function destroy($clave = false)
    {
        if ($clave) 
        {
            if (is_array($clave))
            {
                foreach ($clave as $key)
                {
                    if (isset($_SESSION[$key]))
                    {
                        unset($_SESSION[$key]);                        
                    }
                }
            }
            else
            {
                if (isset($_SESSION[$clave]))
                {
                    unset($_SESSION[$clave]);                    
                }
            }
        }
        else 
        {
            session_destroy();            
        }
    }
    
    public static function set($clave, $valor)    
    {
        if (!empty($clave)) { $_SESSION[$clave] = $valor; }
    }
    
    public static function get($clave)
    {
        if (isset($_SESSION[$clave]))
        {
            return $_SESSION[$clave];            
        }
    }

    public static function acceso($level)
    {
        if (!Session::get('Autenticado')) 
        {
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }
        
        Session::tiempo();
        
        if (Session::getLevel($level) > Session::getLevel(Session::get('level'))) 
        {
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }
    }
    
    public static function accesoView($level)
    {
        if (!Session::get('Autenticado')) 
        {
            return false;
        }
    
        if (Session::getLevel($level) > Session::getLevel(Session::get('level')))
        {
            return false;
        }
        
        return true;
    }
    
    public static function getLevel($level)
    {
        $role = [
            'admin' => 3,
            'especial' => 2,
            'usuario' => 1,
        ];
        
        if (!array_key_exists($level, $role)) 
        {
            throw new Exception('Error de acceso');
        }
        else 
        {
            return $role[$level];
        }
    }
    
    public static function accesoEstricto(array $level, $noAdmin = false)
    {
        if (!Session::get('Autenticado')) 
        {
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }
        
        Session::tiempo();
        
        if (!$noAdmin) 
        {
            if (Session::get('level') == 'admin') 
            {
                return;
            }
        }
        
        if (count($level)) 
        {
            if (in_array(Session::get('level'), $level)) 
            {
                return;
            }
        }
        
        header('location:' . BASE_URL . 'error/access/5050');
        exit;
    }
    
    public static function accesoEstrictoView(array $level, $noAdmin = false)
    {
        if (!Session::get('Autenticado'))
        {
            return false;
        }
    
        if (!$noAdmin)
        {
            if (Session::get('level') == 'admin')
            {
                return true;
            }
        }
    
        if (count($level))
        {
            if (in_array(Session::get('level'), $level))
            {
                return true;
            }
        }
    
        return false;
    }
    
    public static function tiempo()
    {
        if (!Session::get('tiempo') || !defined('SESSION_TIME')) 
        {
            throw new Exception('No se ha definido el tiempo de sesión');
        }
        
        if (SESSION_TIME == 0) 
        {
            return;
        }
        
        if (time() - Session::get('tiempo') > (SESSION_TIME * 60)) 
        {
            Session::destroy();
            header('location:' . BASE_URL . 'error/access/8080');
            exit;            
        }
        else 
        {
            Session::set('tiempo', time());
        }
    }
}
