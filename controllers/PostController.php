<?php

class PostController extends Controller
{
	private $_post;
	
	public function __construct()
	{
		parent::__construct();
		$this->_post = $this->loadModel('post');
	}
	
	public function index($pagina = false)
	{
		/*
		for ($i = 0; $i < 300; $i++) 
		{
			$model = $this->loadModel('post');
			$model->insertarPost('Un día nublado' . $i, 'Descripción de un día nublado' . $i .'en el paraíso');			
		}
		*/
		
		if (!$this->filterInt($pagina)) 
		{
			$pagina = false;
		}
		
		$this->loadLibrary('Paginador');
		$paginador = new Paginador();
		
		$this->_view->posts = $paginador->paginar($this->_post->getPosts(), $pagina);
		$this->_view->paginacion = $paginador->getView('prueba','post/index');		
		$this->_view->titulo = "Post";			
		$this->_view->renderizar('index','post');
	}
	
	public function nuevo()
	{
		// Session::acceso('especial'); // Comentado porque se está usando acceso estricto en lugar de roles específicos
		Session::accesoEstricto(array('usuario'), true);
		
		$this->_view->titulo = "Nuevo Post";
		$this->_view->setJs(array('nuevo'));
		
		if ($this->getInt('guardar') == 1)
		{
			$this->_view->datos = $_POST;
			
			if (!$this->getTexto('titulo'))
			{
				$this->_view->_error = 'Debe ingresar un título';
				$this->_view->renderizar('nuevo','post');
				exit;
			}
			
			if (!$this->getTexto('cuerpo'))
			{
				$this->_view->_error = 'Debe ingresar el cuerpo del post';
				$this->_view->renderizar('nuevo','post');
				exit;
			}
			
			$this->_post->insertarPost($this->filtrarPOST('titulo'), $this->filtrarPOST('cuerpo'));
			
			$this->redireccionar('post');
		}
		
		$this->_view->renderizar('nuevo','post');
	}
	
	public function editar($id)
	{
		if (!$this->filterInt($id)) 
		{
			$this->redireccionar('post');
		}
		
		if (!$this->_post->getPost($this->filterInt($id)))
		{
			$this->redireccionar('post');
		}
		
		$this->_view->titulo = 'Editar post';
		$this->_view->setJs(array('nuevo'));
		
		if ($this->getInt('guardar') == 1)
		{
			$this->_view->datos = $_POST;
			
			if (!$this->getTexto('titulo'))
			{
				$this->_view->_error = 'Debe ingresar un título';
				$this->_view->renderizar('editar','post');
				exit;
			}
			
			if (!$this->getTexto('cuerpo'))
			{
				$this->_view->_error = 'Debe ingresar el cuerpo del post';
				$this->_view->renderizar('editar','post');
				exit;
			}
			
			$this->_post->editarPost($this->filterInt($id), $this->filtrarPOST('titulo'), $this->filtrarPOST('cuerpo'));
			
			$this->redireccionar('post');
		}
		
		$this->_view->datos = $this->_post->getPost($this->filterInt($id));		
		$this->_view->renderizar('editar','post');
	}
	
	public function eliminar($id)
	{
		Session::acceso('admin');
		
		if (!$this->filterInt($id))
		{
			$this->redireccionar('post');
		}
		
		if (!$this->_post->getPost($this->filterInt($id)))
		{
			$this->redireccionar('post');
		}
		
		$this->_post->eliminarPost($this->filterInt($id));
		$this->redireccionar('post');
	}
	
	/* Ejemplo de paginacion con otros modelos, controllers y vista */
	public function producto($pagina = false)
	{
		/*
		for ($i = 0; $i < 300; $i++)
		{
			$model = $this->loadModel('post');
			$model->insertarProducto('Producto' . $i, 5, 10);
		}
		*/
	
		if (!$this->filterInt($pagina))
		{
			$pagina = false;
		}
	
		$this->loadLibrary('Paginador');
		$paginador = new Paginador();
	
		$this->_view->productos = $paginador->paginar($this->_post->getProductos(), $pagina);
		$this->_view->paginacion = $paginador->getView('prueba','post/producto');
		$this->_view->titulo = "Productos";
		$this->_view->renderizar('producto','post');
	}
	
}
