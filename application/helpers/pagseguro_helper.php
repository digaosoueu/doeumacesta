<?php
defined('BASEPATH') OR exit('No direct script access allowed');



if(!function_exists ( 'DadosTransaction' )){
	
	function DadosTransaction($transaction, $ID, $codeCheckout){
		
		$CI = &get_instance();
		
        $CI->load->model( "Pagseguro_model", "PagM" );
        $CI->load->model( "Carrinho_model", "CarrinhoM" );
        
		$Code = $transaction->getCode();
		$Status = $transaction->getStatus()->getTypeFromValue();
		$Reference = $transaction->getReference();
		
		$paymentMethod = $transaction->getPaymentMethod();
		$type = $paymentMethod->getType();
		$tipoPagamento = $type->getTypeFromValue();
		$UrlBoleto = "";
		
		if($tipoPagamento == "BOLETO"){
			$UrlBoleto = "https://pagseguro.uol.com.br/checkout/imprimeBoleto.jhtml?resizeBooklet=n&code=" . $Code;
		}
		$ID = str_pad($ID, 10, "0", STR_PAD_LEFT);
		$objeto = array (
				"cod_carrinho" => $ID,
				"cod_transacao" => $Code,
				"status" => $Status,
				"tipoPagamento" => $tipoPagamento,
				"cod_checkout" => $codeCheckout,
				"url_boleto" => $UrlBoleto
		);
		
		$cod_carrinho = $CI->PagM->postRetorno( $objeto );		
		
		if ($Status == "PAID"){			
			
			$itens = array (
					"situacao" => "P"
			);
			$CI->CarrinhoM->update( $itens, $ID );
			
		}
		
		if ($Status == "CANCELLED"){
				
			$itens = array (
					"situacao" => "C"
			);
			$CI->CarrinhoM->update( $itens, $ID );
				
		}
		
		
				
		return "";
	}
}


