<?php

	class PdfController extends Controller
	{
		private $_pdf;
		
		public function __construct()
		{
			parent::__construct();
			$this->loadLibrary('fpdf');
			$this->_pdf = new FPDF;
			
		}
		
		public function index()
		{
			
		}
		
		public function pdf1($nombre, $apellido)
		{
			require_once ROOT . 'public' . DS . 'files' . DS. 'pdf2.php';			
		}
		
	}

?>
