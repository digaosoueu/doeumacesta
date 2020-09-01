<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conteudo extends CI_Controller {

	public function __construct() {

		parent::__construct ();
		$this->layout = LAYOUT_LOJA;
		
	}
	
	public function contato(){
		
		$data = array();
		
		$this->parser->parse ( "Pagina_contato", $data );
	}
	
	public function cestabasicacompleta(){
	
		$data = array();
	
		$this->parser->parse ( "Pagina_conteudo", $data );
	}
	
	public function quemsomos(){
	
		$data = array();
	
		$this->parser->parse ( "Pagina_quemsomos", $data );
	}
	
	public function quemajudamos(){
	
		$data = array();
	
		$this->parser->parse ( "Pagina_quemajudamos", $data );
	}
	
}