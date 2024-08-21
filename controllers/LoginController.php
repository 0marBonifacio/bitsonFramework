<?php

class LoginController extends Controller
{
	private $_login;
	
	public function __construct()
	{
		parent::__construct();
		$this->_login = $this->loadModel('login');
	}
	
	public function index()
	{
		if (Session::get('Autenticado')) 
		{
			$this->redireccionar();
		}
		$this->_view->titulo = "Iniciar sesión";
		
		if ($this->getInt('enviar')==1)
		{
			$this->_view->datos = $_POST;
			
			
			if (!$this->getAlphaNum('usuario')) 
			{
				$this->_view->_error = 'Debe introducir un nombre de usuario válido';
				$this->_view->renderizar('index','login');
				exit;
			}
			
			if (!$this->getSql('password')) 
			{	
				$this->_view->_error = 'Debe ingresar una contraseña válida';
				$this->_view->renderizar('index','login');
				exit;
			}
			
			$row = $this->_login->getUsuario($this->getAlphaNum('usuario'),$this->getSql('password'));
			
			if (!$row) 
			{
				$this->_view->_error = 'Usuario y/o Password incorrectos';
				$this->_view->renderizar('index','login');
				exit;
			}
			
			if ($row['estado'] != 1) 
			{
				$this->_view->_error = 'El usuario no está habilitado';
				$this->_view->renderizar('index','login');
				exit;
			}
			
			Session::set('Autenticado', true);
			Session::set('level', $row['role']);
			Session::set('usuario', $row['usuario']);
			Session::set('idUsuario', $row['id']);
			Session::set('tiempo', time());
			
			$this->redireccionar();
		}
		
		$this->_view->renderizar('index','login');
			
	}
		
	public function cerrar()
	{
		Session::destroy();
		$this->redireccionar();
	}
	
}