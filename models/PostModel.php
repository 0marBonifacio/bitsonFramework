<?php
class PostModel extends Model
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function getPosts()
	{
		$post = $this->_db->query("SELECT * FROM Posts");
		
		return $post->fetchAll();
	}
	
	public function getPost($id)
	{
		$id = (int) $id;
		$post = $this->_db->query("SELECT * FROM Posts WHERE id=$id");
		
		return $post->fetch();
	}

	public function insertarPost($titulo, $cuerpo)
	{
		$this->_db->prepare("INSERT INTO Posts VALUES(NULL, :titulo, :cuerpo)")
		->execute(array(':titulo' => $titulo,':cuerpo' => $cuerpo));
	}
	
	public function editarPost($id, $titulo, $cuerpo)
	{
		$this->_db->prepare("UPDATE Posts SET titulo=:titulo, cuerpo = :cuerpo WHERE id=:id")
		->execute(array(':id' =>$id,':titulo' => $titulo,':cuerpo' => $cuerpo));
	}

	public function eliminarPost($id)
	{
		$id = (int) $id;
		$this->_db->query("DELETE FROM Posts WHERE id=$id");
	}
	
	/* Ejemplo de paginacion con otros modelos, controllers y vista */
	public function insertarProducto($nombre, $precio, $stock)
	{
		$this->_db->prepare("INSERT INTO Producto VALUES(NULL, :nombre, :precio, :stock)")
		->execute(array(':nombre' => $nombre,':precio' => $precio, ':stock' => $stock));
	}
	
	public function getProductos()
	{
		$post = $this->_db->query("SELECT * FROM Producto");
	
		return $post->fetchAll();
	}

}