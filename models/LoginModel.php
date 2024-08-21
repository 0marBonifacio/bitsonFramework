<?php

class LoginModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getUsuario($user, $pass)
	{
		$datos = $this->_db->query("SELECT * FROM Usuario WHERE usuario='$user' AND pass='".Hash::getHash('sha1', $pass, HASH_KEY)."'");
		
		return $datos->fetch();
	}
	
}