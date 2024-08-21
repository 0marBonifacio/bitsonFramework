<?php

class RegistroModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function verificarUsuario($usuario)
	{
		$id = $this->_db->query("SELECT id, codigo FROM Usuario WHERE usuario='$usuario'");
						
		return $id->fetch();
	}
	
	public function verificarEmail($email)
	{
		$id = $this->_db->query("SELECT id FROM Usuario WHERE email='$email'");
	
		if ($id->fetch())
		{
			return true;
		}
	
		return false;
	}
	
	public function registrarUsuario($nombre,$usuario,$password,$email)
	{
		$random = rand(1234567890, 9999999999);
		$this->_db->prepare
				    (
				    "INSERT INTO Usuario VALUES".
				    "(null, :nombre, :usuario, :pass, :email, 'usuario', 0, now(), :codigo)"				
				    )
				  ->execute(array
				    (
				    ':nombre' => $nombre,
				    ':usuario' => $usuario,
				    ':pass' => Hash::getHash('sha1', $password, HASH_KEY),
				    ':email' => $email,
				    ':codigo' => $random
				    ));
	}
	
	public function getUsuario($id, $codigo)
	{
		$usuario = $this->_db->query("SELECT * FROM Usuario WHERE id='$id' AND codigo='$codigo'");
		
		return $usuario->fetch();
	}
	
	public function activarUsuario($id, $codigo)
	{
		$this->_db->query("UPDATE Usuario SET estado=1 WHERE id='$id' AND codigo='$codigo'");
	}
	
}