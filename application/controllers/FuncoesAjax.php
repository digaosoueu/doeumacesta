<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FuncoesAjax extends CI_Controller {
	
	public function __construct() {
		parent::__construct ();
		$this->load->model( "Sku_model", "SkuM" );
		$this->load->helper('cookie');
	}
	
	public function EnviaEmailContato(){
		
		$Email = $this->input->post( "email" );
		$Nome = $this->input->post( "nome" );
		$Mensagem = $this->input->post( "mensagem" );
		
		if(!$Email){		
				
			echo "Preencha todos os dados";	
		
		}else{
			
			$data = array(
				
					"NOME" => $Nome,
					"EMAIL" => $Email,
					"MENSAGEM" => $Mensagem
					
			);
			
			$retorno = enviarEmail("sac@doeumacesta.com.br", $Nome, "digaosoueu@gmail.com", "Contato Enviado - doeumacesta","Contato", $data);
			if($retorno == ""){
				echo "OK";
			}else{
				echo $retorno;
			}
			
		}
	
	}
	
	public function gravarCodPagamento($cod){
		//echo $cod;
		$this->session->set_userdata('CodPagamentoDoeUmaCesta', $cod);
		//$codformapagamento = $this->session->userdata( "CodPagamentoDoeUmaCesta" );
		//echo $codformapagamento;
		
	}
	
	public function CadastrarNews(){
		
		$Email = $this->input->get( "Email" );
		$Nome = $this->input->get( "Nome" );
		$Retorno = "";
		
		if($Email){
			
			$this->load->helper('email');
			
			if (valid_email($Email)){
				
				$this->load->model( "Funcoes_model", "FuncoesM" );
			
			
				$sEmail = $this->FuncoesM->getNews(array (
						"Email" => $Email
				));
				
				if($sEmail){
					
					$Retorno = "Existe";
					
				}else{
					
					$itens = array (
						"email" => $Email,
						"nome" => $Nome,
					);
								
					$Retorno = $this->FuncoesM->InsertNews( $itens );
				}		
				
			}else{
				$Retorno = "invalido";
			}
			
		}
		echo $Retorno;
	}
	
	
	
	public function carregaMiniCar(){
		
		$carrinho = get_cookie( "carrinhoDoeumaCesta" );//$this->session->userdata( "carrinhoDoeumaCesta" );
		
		if (!$carrinho) {
			$carrinho = array();
		} else {
			$carrinho = unserialize( $carrinho );

		}
		
		
		$data = array ();
		$data["SUBTOTALCARRINHO"] = "0,00";
		$data ["BLC_PRODUTOS"] = array ();
		$data ["BLC_SEMPRODUTOS"] = array ();
		$QtdTot = 0;
		 
		if (sizeof( $carrinho ) === 0) {
			$data ["BLC_SEMPRODUTOS"] [] = array ();
		} else {
		
			foreach ( $carrinho as $codsku => $quantidade ) {
				 
				$infoSKU = $this->SkuM->getPorSKU ( $codsku );
				 
				if (($infoSKU->valorpromocional > 0) && ($infoSKU->valorproduto > $infoSKU->valorpromocional)) {
					$valorFinal = $infoSKU->valorpromocional;
				} else {
					$valorFinal = $infoSKU->valorproduto;
				}
				$valorTotal = $valorFinal * $quantidade;
				 
				$referencia = "";
				 
				if (! empty ( $infoSKU->referencia )) {
					$referencia = " - " . $infoSKU->referencia;
				}
				 
				 
				$data ["BLC_PRODUTOS"] [] = array (
						"NOMEPRODUTO" => $infoSKU->nomeproduto . $referencia,
						"QUANTIDADE" => $quantidade,
						"VALOR" => number_format( $valorFinal, 2, ",", "." ),
						"VALORTOTAL" => number_format ( $valorTotal, 2, ",", "." ),
						"CODSKU" => $infoSKU->codsku
				);
				$QtdTot++;
				
				$valorTotalCarrinho = $this->getPrecoCarrinho(FALSE);
				
				$data ["SUBTOTALCARRINHO"] = number_format( $valorTotalCarrinho, 2, ",", "." );
			}
		
		}
		$data ["QTD_TOTAL"] = $QtdTot;
		
		$this->parser->parse( "CarregaMiniCar", $data );
	}
	
	public function addCard($codsku){
	
		//$codproduto = $this->input->post ( "codproduto" );
		// $codsku = $this->input->post ( "codsku" );
		$Retorno = "";
	
		$carrinho = get_cookie( "carrinhoDoeumaCesta" );//$this->session->userdata( "carrinhoDoeumaCesta" );

		//echo $carrinho;
	
		if (!$carrinho) {
			$carrinho = array ();
		} else {
			$carrinho = unserialize( $carrinho );
		}
	
		$infoSKU = $this->SkuM->getPorSKU( $codsku );
	
		if ($infoSKU) {
	
			if (!isset ( $carrinho[$codsku] )) {
				if ($infoSKU->quantidade > 0) {
					$carrinho [$codsku] = 1;
				}
			} else {
	
				//if ($infoSKU->quantidade > $carrinho[$codsku] + 1) {
					$carrinho[$codsku] = $carrinho[$codsku] + 1;
				//}
			}
		}
	//$this->session->set_userdata( "carrinhoIDDoeumaCesta", "carrinho" );
		$carrinho = serialize( $carrinho );

		set_cookie("carrinhoDoeumaCesta", $carrinho, 86400*30);

		//$this->session->set_userdata( "carrinhoDoeumaCesta", $carrinho );

	
		if($carrinho){$Retorno = "OK";}
		
		echo $Retorno;
	}
	
	public function diminuiCard($codsku) {
		$carrinho = get_cookie( "carrinhoDoeumaCesta" );//$this->session->userdata ( "carrinhoDoeumaCesta" );
	
		if (! $carrinho) {
			$carrinho = array ();
		} else {
			$carrinho = unserialize ( $carrinho );
		}
	
		$infoSKU = $this->SkuM->getPorSKU ( $codsku );
	
		if ($infoSKU) {
	
			if (!isset( $carrinho[$codsku] )) {
				//if ($infoSKU->quantidade > 0) {
					$carrinho [$codsku] = 1;
				//}
			} else {
				//if (($carrinho[$codsku] - 1) <= 0) {
				//	$carrinho[$codsku] = 1;
				//} elseif ($infoSKU->quantidade > $carrinho [$codsku] - 1) {
					//$carrinho [$codsku] = $carrinho [$codsku] - 1;
				//}
				if(($carrinho[$codsku] - 1) <= 0){
					$carrinho[$codsku] = 1;
				}else{
					$carrinho [$codsku] = $carrinho [$codsku] - 1;
				}
			}
		}
	
		$carrinho = serialize($carrinho);
		set_cookie("carrinhoDoeumaCesta", $carrinho, 86400*30);//$this->session->set_userdata ( "carrinhoDoeumaCesta", $carrinho );
		
		$this->CarregaCarrinho($carrinho);
		//redirect ( "checkout" );
	}
	
	public function adicionaCard($codsku) {
		$carrinho = get_cookie( "carrinhoDoeumaCesta" );//$this->session->userdata ( "carrinhoDoeumaCesta" );
	
		if (! $carrinho) {
			$carrinho = array ();
		} else {
			$carrinho = unserialize ( $carrinho );
		}
	
		$infoSKU = $this->SkuM->getPorSKU($codsku);
	
		if ($infoSKU) {
	
			if (!isset($carrinho[$codsku])) {
				//if ($infoSKU->quantidade > 0) {
					$carrinho[$codsku] = 1;
				//}
			} else {
	
				//if ($infoSKU->quantidade > $carrinho [$codsku] + 1) {
					$carrinho[$codsku] = $carrinho[$codsku] + 1;
				//}
			}
		}
	
		$carrinho = serialize ( $carrinho );
		set_cookie("carrinhoDoeumaCesta", $carrinho, 86400*30);//$this->session->set_userdata ( "carrinhoDoeumaCesta", $carrinho );
	
		$this->CarregaCarrinho($carrinho);
	}
	
	public function removerCard($codsku) {
		$carrinho = get_cookie( "carrinhoDoeumaCesta" );//$this->session->userdata ( "carrinhoDoeumaCesta" );
	
		if (! $carrinho) {
			$carrinho = array ();
		} else {
			$carrinho = unserialize ( $carrinho );
		}
	
		unset ( $carrinho [$codsku] );
	
		$carrinho = serialize($carrinho);
		set_cookie("carrinhoDoeumaCesta", $carrinho, 86400*30);//$this->session->set_userdata ( "carrinhoDoeumaCesta", $carrinho );
	
		$this->CarregaCarrinho($carrinho);
	}
	
	public function CarregaCarrinho($car = null) {
		if ($car == null){
			$carrinho = get_cookie( "carrinhoDoeumaCesta" );
		}else{
			$carrinho = $car;
			//exit;
		}//$this->session->userdata ( "carrinhoDoeumaCesta" );
	
		if (!$carrinho) {
			$carrinho = array();
		} else {
			$carrinho = unserialize( $carrinho );
		}
	
		$data = array ();
		$data["BLC_PRODUTOS"] = array ();
		$data["BLC_FINALIZAR"] = array ();
		$data["BLC_SEMPRODUTOS"] = array ();
		$data["BCL_TOTALCARRINHO"] = array ();
	
		if (sizeof( $carrinho ) === 0) {
			$data["BLC_SEMPRODUTOS"] [] = array ();
		} else {
			foreach ( $carrinho as $codsku => $quantidade ) {
				$infoSKU = $this->SkuM->getPorSKU ( $codsku );
	
				if (($infoSKU->valorpromocional > 0) && ($infoSKU->valorproduto > $infoSKU->valorpromocional)) {
					$valorFinal = $infoSKU->valorpromocional;
				} else {
					$valorFinal = $infoSKU->valorproduto;
				}
				$valorTotal = $valorFinal * $quantidade;
	
				$referencia = "";
	
				if (! empty ( $infoSKU->referencia )) {
					$referencia = " - " . $infoSKU->referencia;
				}
	
				$urlFoto = base_url("assets/img/produto/80x80") . "/" . $infoSKU->produtofoto;
	
				// if (! empty ( $infoSKU->codprodutofotosku )) {
				// 	$urlFoto = base_url ( "assets/img/produto/80x80/" . $infoSKU->codprodutofotosku . "." . $infoSKU->produtofotoextensaosku );
				// } else {
				// 	$urlFoto = base_url ( "assets/img/produto/80x80/" . $infoSKU->codprodutofoto . "." . $infoSKU->produtofotoextensao );
				// }
	
				$data ["BLC_PRODUTOS"] [] = array (
						"URLFOTO" => $urlFoto,
						"NOMEPRODUTO" => $infoSKU->nomeproduto . $referencia,
						"QUANTIDADE" => $quantidade,
						"VALOR" => number_format ( $valorFinal, 2, ",", "." ),
						"VALORTOTAL" => number_format ( $valorTotal, 2, ",", "." ),
						"CODSKU" => $infoSKU->codsku,
						"URLAUMENTAQTD" => site_url ( "checkout/aumenta/" . $infoSKU->codsku ),
						"URLDIMINUIQTD" => site_url ( "checkout/diminui/" . $infoSKU->codsku ),
						"URLREMOVEQTD" => site_url ( "checkout/remove/" . $infoSKU->codsku )
				);
			}
	
			$data ["BLC_FINALIZAR"] [] = array (
					"URLFINALIZAR" => site_url ( 'checkout/formaentrega' )
			);
		}
		
		$valorTotalCarrinho = $this->getPrecoCarrinho(FALSE, $carrinho);
		$data ["BCL_TOTALCARRINHO"] [] = array (
			"SUBTOTALCARRINHO" => number_format( $valorTotalCarrinho, 2, ",", "." ),
        	"TOTALCARRINHO" => number_format( $valorTotalCarrinho, 2, ",", "." )
		);
		
		$this->parser->parse( "carrinho", $data );
	}
	
	private function getPrecoCarrinho($codformapagamento = false, $car = null) {

		if($car == null){
			$carrinho = get_cookie( "carrinhoDoeumaCesta" );//$this->session->userdata ( "carrinhoDoeumaCesta" );
		}
		else{
			$carrinho = $car;
		}
	
		if (!$carrinho) {
			$carrinho = array ();
		} else {
			if($car == null){$carrinho = unserialize($carrinho);}
		}
	
		$valorTotal = 0;
	
		foreach ( $carrinho as $codsku => $quantidade ) {
			$infoSKU = $this->SkuM->getPorSKU ( $codsku );
	
			if (($infoSKU->valorpromocional > 0) && ($infoSKU->valorproduto > $infoSKU->valorpromocional)) {
				$valorFinal = $infoSKU->valorpromocional;
			} else {
				$valorFinal = $infoSKU->valorproduto;
			}
			$valorTotal += $valorFinal * $quantidade;
		}
	
		if ($codformapagamento) {
			$this->load->model ( "FormaPagamento_Model", "FormaPagamentoM" );
	
			$formasPagamento = $this->FormaPagamentoM->get ( array (
					"codformapagamento" => $codformapagamento
			), TRUE );
	
			if ($formasPagamento->descontoformapagamento > 0) {
				$valorTotal = $valorTotal - (($valorTotal * $formasPagamento->descontoformapagamento) / 100);
			}
		}
	
		return $valorTotal;
	}
}