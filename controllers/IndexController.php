<?php

class IndexController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->_view->titulo = 'Home';
		$this->_view->renderizar('index','inicio');
	}
}