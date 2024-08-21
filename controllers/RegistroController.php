<?php

class RegistroController extends Controller
{
	private $_registro;
	
	public function __construct()
	{
		parent::__construct();
		$this->_registro = $this->loadModel('registro');
	}
	
	public function index()
	{
		if (Session::get('Autenticado')) 
		{
			$this->redireccionar();
		}
		
		if ($this->getInt('enviar') == 1) 
		{
			$this->_view->datos = $_POST;
			
			if (!$this->getSql('nombre')) 
			{
				$this->_view->_error = 'Debe ingresar un nombre válido';
				$this->_view->renderizar('index','registro');
				exit;
			}
			
			if (!$this->getAlphaNum('usuario'))
			{
				$this->_view->_error = 'Debe ingresar un nombre de usuario válido';
				$this->_view->renderizar('index','registro');
				exit;
			}
			
			if ($this->_registro->verificarUsuario($this->getAlphaNum('usuario')))
			{
				$this->_view->_error = 'El usuario <b>' . $this->getAlphaNum('usuario') . '</b> ya existe';
				$this->_view->renderizar('index','registro');
				exit;
			}
			
			if (!$this->validarEmail($this->getTexto('email')))
			{
				$this->_view->_error = 'La dirección email no es válida';
				$this->_view->renderizar('index','registro');
				exit;
			}
			
			if ($this->_registro->verificarEmail($this->getTexto('email')))
			{
				$this->_view->_error = 'El email <b>' . $this->getTexto('email') . '</b> ya está registrado';
				$this->_view->renderizar('index','registro');
				exit;
			}
			
			if (!$this->getSql('password'))
			{
				$this->_view->_error = 'Ingrese una contraseña';
				$this->_view->renderizar('index','registro');
				exit;
			}
			
			if ($this->getTexto('password') != $this->getTexto('password2'))
			{
				$this->_view->_error = 'Las contraseñas no coinciden';
				$this->_view->renderizar('index','registro');
				exit;
			}
			
			$this->loadLibrary('class.phpmailer');
			$mail = new PHPMailer();
			
			$this->_registro->registrarUsuario
							  (
							  $this->getSql('nombre'),
							  $this->getAlphaNum('usuario'),
							  $this->getTexto('password'),
							  $this->getTexto('email')							  
							  );
			$usuario = $this->_registro->verificarUsuario($this->getAlphaNum('usuario'));
			
			if (!$usuario)
			{
				$this->_view->_error = 'Error al registrar el usuario <b>' . $this->getAlphaNum('usuario') . '</b>';
				$this->_view->renderizar('index','registro');
				exit;
			}
			
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "ssl";
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 465;
			$mail->Username = "siss.itistmo@gmail.com";
			$mail->Password = "_S155_itistmo_";
			
			$mail->From = 'www.bitsonframework.org';
			$mail->FromName = "Bitson Framework PHP";
			$mail->Subject = "Activación de cuenta de usuario";
			
			$msge = 'Hola <strong>'.$this->getSql('nombre').'</strong> :'.
					'<p>Se ha registrado en www.bitsonframework.org, para activar su cuenta'.
					'haga clic en el siguiente enlace:<br/>'.
					'<a href="' . BASE_URL . 'registro/activar/'. $usuario['id'] . '/' . $usuario['codigo']. '">'. 
					BASE_URL . 'registro/activar/'. $usuario['id'] . '/' . $usuario['codigo'].
					'</a></p>';
			
			$mail->MsgHTML($msge);
			$mail->AddAddress($this->getTexto('email'));
			$mail->IsHTML(true);
			$mail->send();
			
			$this->_view->datos = false;
			$this->_view->_mensaje = 'Registro completado, revise su email para activar su cuenta. ' . 
				'Enlace de activación: ' . BASE_URL . 'registro/activar/'. $usuario['id'] . '/' . $usuario['codigo'];			
		}
		
		$this->_view->titulo = 'Registro';
		$this->_view->renderizar('index','registro');
	}
	
	public function activar($id, $codigo)
	{
		if (!$this->filterInt($id) || !$this->filterInt($codigo)) 
		{
			$this->_view->_error = 'Esta cuenta no existe';
			$this->_view->renderizar('activar','registro');
			exit;
		}
		
		$row = $this->_registro->getUsuario($this->filterInt($id), $this->filterInt($codigo));
		
		if (!$row)
		{
			$this->_view->_error = 'Esta cuenta no existe';
			$this->_view->renderizar('activar','registro');
			exit;
		}
		
		if ($row['estado'] == 1)
		{
			$this->_view->_error = 'Esta cuenta ya ha sido activada';
			$this->_view->renderizar('activar','registro');
			exit;
		}
		
		$this->_registro->activarUsuario($this->filterInt($id), $this->filterInt($codigo));
		
		$row = $this->_registro->getUsuario($this->filterInt($id), $this->filterInt($codigo));
		
		if ($row['estado'] == 0) 
		{
			$this->_view->_error = 'Error al activar la cuenta, por favor intente más tarde';
			$this->_view->renderizar('activar','registro');
			exit;
		}
		
		$this->_view->_mensaje = 'Su cuenta ha sido activada satisfactoriamente';		
		$this->_view->renderizar('activar','registro');
	}
	
}
