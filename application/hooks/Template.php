<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template{

   public function init(){

    	$CI     = &get_instance();
    	$output = $CI->output->get_output();
	
		if(isset($CI->layout)){
			
			if($CI->layout){
				
				$layoutOriginal = $CI->layout;
				
				//$erroDash = $CI->session->flashdata('erro');
				//$sucessoDash = $CI->session->flashdata('sucesso');
				
				
				if(!preg_match('/(.+).php$/', $CI->layout)){$CI->layout .= '.php';}
				
				$template = APPPATH . 'templates/' . $CI->layout;
				
				if(file_exists($template)){
					$layout = $CI->load->file($template, true);
				}else{
					die('Template invalido');
				}
				
				$html = str_replace("{CONTEUDO}", $output, $layout);
				
				if($layoutOriginal == LAYOUT_LOJA){
					
					$this->tratamentoLoja($CI, $html);
				}
				
				//if($erroDash){
				//	$erroDash = $this->criaAlerta($erroDash, 'alert-danger', 'Ops');
				//	$html = str_replace("{MENSAGEM_SISTEMA_ERRO}", $erroDash, $html);
				//}else{
				//	$html = str_replace("{MENSAGEM_SISTEMA_ERRO}", null, $html);
				//}
				
				//if($sucessoDash){
				//	$sucessoDash = $this->criaAlerta ($sucessoDash, 'alert-success', 'OK');
				//	$html = str_replace("{MENSAGEM_SISTEMA_SUCESSO}", $sucessoDash, $html);
				//}else{
				//	$html = str_replace("{MENSAGEM_SISTEMA_SUCESSO}", null, $html);
				//}
				
			}else{
				$html = $output;
			}
		}else{
			$html = $output;
		}
		
		$CI->output->_display($html);
   }
   
 private function criaAlerta($mensagem, $tipo, $titulo) {
        $html = "<div class=\"alert {$tipo}\" role='alert'>\n";
        $html .= "\t<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>\n";
        $html .= "\t<strong>{$titulo}!</strong> {$mensagem}\n";
        $html .= "</div>";
        return $html;
    }
    
    private function deleteAllBetween($beginning, $end, $string) {
    	$beginningPos = strpos( $string, $beginning );
    	$endPos = strpos ( $string, $end );
    
    	if (! $beginningPos || ! $endPos) {
    		return $string;
    	}
    
    	$textToDelete = substr ( $string, $beginningPos, ($endPos + strlen ( $end )) - $beginningPos );
    	return str_replace ( $textToDelete, '', $string );
    }
    
    private function tratamentoLoja($CI, &$html){
    	
    	$title = isset($CI->title)?$CI->title:'Doe uma cesta Basica';
    	$descricao = isset($CI->descricao)?$CI->descricao:'Doe uma cesta Basica, faça caridade';
    	$keyw = isset($CI->keyw)?$CI->keyw:'cesta basica, caridade, doação';
    	//$html = str_replace("{TITLE}", $title, $html);
    	$this->setVariable("TITLE", $title, $html);
    	$this->setVariable("DESCRIPTION", $descricao, $html);
    	$this->setVariable("KEYWORDS", $keyw, $html);
    	
    	$erroDash = $CI->session->flashdata('erro');
    	$sucessoDash = $CI->session->flashdata('sucesso');
    	if($erroDash){
    		$erroDash = $this->criaAlerta($erroDash, 'alert-danger', 'Ops');
    		$this->setVariable("MENSAGEM_SISTEMA_ERRO", $erroDash, $html);
    	}else{
    		$this->setVariable("MENSAGEM_SISTEMA_ERRO", null, $html);
    	}
    	
    	if($sucessoDash){
    		$sucessoDash = $this->criaAlerta($sucessoDash, 'alert-info', 'OK');
    		$this->setVariable("MENSAGEM_SISTEMA_SUCESSO", $sucessoDash, $html);
    	}else{
    		
    		$this->setVariable("MENSAGEM_SISTEMA_SUCESSO", null, $html);
    	}
    	
    	$comprador = $CI->session->userdata( 'UserDoeUmaCesta' );
    	
    	
    	if ($comprador) {
    		
    		$this->setVariable( "NOMECLIENTE", $comprador["nomecomprador"], $html );
    		$html = $this->deleteAllBetween ( "<naologado>", "</naologado>", $html );
    		
    	} else {
    		$this->setVariable( "NOMECLIENTE", 'Visitante', $html );
    		$html = $this->deleteAllBetween ( "<logado>", "</logado>", $html );
    		$html = $this->deleteAllBetween ( "<logado2>", "</logado2>", $html );
    	}
    	$this->setVariable("ACAOFORMLOGIN", site_url("conta/valida"), $html);
    	
    	$redirect = str_replace(site_url(), "", current_url());
    	
    	$this->setVariable("REDIRECT", $redirect, $html);
    	//if(current_url() == site_url()){
        if(current_url() == "testeBanner"){
    		
    		$this->setVariable("DATAOFFSETTOP", "500", $html);
    		$this->setVariable("DATASTUCK", "600", $html);    		
    		
    	}else{
    		
    		$this->setVariable("DATAOFFSETTOP", "150", $html);
    		$this->setVariable("DATASTUCK", "150", $html);
    		$html = $this->deleteAllBetween ( "<NmostraSlider>", "</NmostraSlider>", $html );
    	}
    	
    	$CI->load->model( "Produto_model", "ProdutoM" );
		
		$produto = $CI->ProdutoM->get( array(), FALSE, 0, 4, "codproduto", rand() );
		$CI->load->helper("Produtossemelhantes");
    	$this->setVariable("PRODUTOSEMELHANTES", montaListaProdutoSemel( $produto ), $html);
		
		$this->setVariable("AVISOPAGAMENTO", AVISOPAGAMENTO, $html);
    	
    }
    
    private function setVariable($name, $value, &$html) {
    	$html = str_replace ( "{" . $name . "}", $value, $html );
    }
}		