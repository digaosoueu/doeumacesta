<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	
	public function index()
	{
		$this->layout = LAYOUT_LOJA;		
		
		$this->load->model ( "Vitrine_model", "VitrineM" );
		
		$dataatual = date ( "Y-m-d" );
		
		$filtro = array (
				"vitrineativa" => 1,
				"datainiciovitrine <= " => $dataatual,
				"datafinalvitrine >= " => $dataatual
		);
		
		$vitrine = $this->VitrineM->get ( $filtro, TRUE );
		//var_dump($vitrine);
		//echo $vitrine->codvitrine;exit;
		$produto = FALSE;
		
		if ($vitrine) {
			$this->load->model ( "VitrineProduto_model", "VitrineProdutoM" );
		
			$filtro = array (
					"v.codvitrine" => $vitrine->codvitrine
			);
		
			$produto = $this->VitrineProdutoM->get( $filtro, FALSE, 0, FALSE );
		}
		
		if (!$produto) {
			$this->load->model ( "Produto_model", "ProdutoM" );
		
			$produto = $this->ProdutoM->get( array(), FALSE, 0, LINHAS_PESQUISA_DASHBOARD, "codproduto", "Asc" );
		}
		//var_dump($produto);exit;
		$data = array();
		
		$html = montaListaProduto( $produto );
		$data = array ();
		$data ["LISTAGEM"] = $html;
		
				
		$this->parser->parse( "inicio", $data );
		
		
		//$this->load->view('inicio');
		
		
	}
}
