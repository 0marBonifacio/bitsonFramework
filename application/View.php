<?php

class View
{
    private $_controlador;
    private $_js;
    
    public function __construct(Request $peticion)
    {
        $this->_controlador = $peticion->getControlador();
        $this->_js = array();
    }
    
    public function renderizar($vista, $item = false)
    {
        $menu = array(
            array(
                'id'      => 'inicio',
                'titulo'  => 'Home',
                'enlace'  => BASE_URL
            ),
            array(
                'id'      => 'post',
                'titulo'  => 'Post',
                'enlace'  => BASE_URL . 'post'
            )
        );
        
        if (Session::get('Autenticado')) 
        {
            $menu[] = array(
                'id'      => 'login',
                'titulo'  => 'Cerrar sesión',
                'enlace'  => BASE_URL . 'login/cerrar'
            );
        }
        else
        {
            $menu[] = array(
                'id'      => 'login',
                'titulo'  => 'Iniciar sesión',
                'enlace'  => BASE_URL . 'login'
            );
            
            $menu[] = array(
                'id'      => 'registro',
                'titulo'  => 'Registro',
                'enlace'  => BASE_URL . 'registro'
            );
        }
        
        $js = array();
        
        if (count($this->_js)) 
        {
            $js = $this->_js;
        }
        
        $_layoutArgs = array(
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . DS . 'img/',
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . DS . 'css/',
            'ruta_js'  => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . DS . 'js/',
            'menu'     => $menu,
            'js'       => $js
        );
        
        $rutaView = ROOT . 'views' . DS . lcfirst($this->_controlador) . DS . $vista . '.phtml';
        
        if (is_readable($rutaView)) 
        {
            include_once ROOT . 'views/layout/' . DEFAULT_LAYOUT . DS . 'header.php';
            include_once $rutaView;
            include_once ROOT . 'views/layout/' . DEFAULT_LAYOUT . DS . 'footer.php';
        }
        else
        {
            throw new Exception('Error al obtener la vista');            
        }
    }
    
    public function setJs(array $js)
    {
        if (is_array($js) && count($js)) 
        {
            foreach ($js as $file) 
            {
                $this->_js[] = BASE_URL . 'views/' . lcfirst($this->_controlador) . '/js/' . $file . '.js';     
            }
        }
        else 
        {
            throw new Exception("Error JS");
        }
    }
}
