<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Busca extends CI_Controller {
    public function __construct() {
        parent::__construct ();
        $this->layout = LAYOUT_LOJA;
    }
    public function listagem($coddepartamento) {
        $pesquisa = $this->input->get ( "pesquisa" );
        $pg = $this->input->get ( "pg" );
        $to = $tipoOrdenacao = $this->input->get ( "to" );
        $oc = $campoOrdenacao = $this->input->get ( "oc" );
        
        if (! $pesquisa) {
            redirect ();
        }
        
        if (! $pg) {
            $pg = 0;
        } else {
            $pg --;
        }
        
        $offset = LINHAS_PESQUISA_DASHBOARD * $pg;
        
        switch ($tipoOrdenacao) {
            case "asc" :
            case "desc" :
                $tipoOrdenacao = strtoupper( $tipoOrdenacao );
                break;
            default :
                $tipoOrdenacao = "ASC";
        }
        
        switch ($campoOrdenacao) {
            case "nome" :
                $campoOrdenacao = "nomeproduto";
                break;
            case "valor" :
                $campoOrdenacao = "valorproduto";
                break;
            default :
                $campoOrdenacao = "nomeproduto";
        }
        
        $this->load->model ( "Produto_Model", "ProdutoM" );
        
        $filtro = explode ( " ", $pesquisa );
        
        $produto = $this->ProdutoM->getBusca( $filtro, FALSE, $offset, LINHAS_PESQUISA_DASHBOARD, $campoOrdenacao, $tipoOrdenacao );
        
        if (! $produto) {
            //show_error( "Não foram encontrados produtos." );
        	$this->session->set_flashdata ( 'erro', 'Não foram encontrados produtos.' );
        }
        
        $html = montaListaProduto( $produto );
        
        $data = array ();
        $data ["LISTAGEM"] = $html;
        
      
        
        $this->parser->parse ( "inicio", $data );
    }
    
    /**
     * Remapeamento
     *
     * @param unknown $method            
     * @param unknown $params            
     */
    public function _remap($method, $params = array()) {
        if (method_exists ( $this, $method )) {
            return call_user_func ( array (
                    $this,
                    $method 
            ), $params );
        } else {
            $this->listagem ( $method );
        }
    }
}