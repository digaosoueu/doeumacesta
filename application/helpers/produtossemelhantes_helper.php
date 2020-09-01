<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists( 'montaListaProdutoSemel' )) {

	/**
	 * Verifica se o cliente está logado
	 *
	 * @return mixed
	 */
	function montaListaProdutoSemel($produto) {
		 
		$CI = &get_instance();

		$CI->load->model( "ProdutoFoto_model", "ProdutoFotoM" );
		$CI->load->model( "Sku_model", "SkuM" );

		$data ["BLC_LINHA"] = array ();

		$produtosExibidos = 0;
		$coluna = array ();

		foreach ( $produto as $p ) {

			$filtroFoto = array (
					"p.codproduto" => $p->codproduto
			);

			$foto = $CI->ProdutoFotoM->get($filtroFoto, TRUE );

			$url = base_url ( "assets/img/foto-indisponivel.jpg" );

			if ($foto) {
				$url = base_url ( "assets/img/produto/150x150/" . $foto->codprodutofoto . "." . $foto->produtofotoextensao );
			}

			$urlFicha = site_url ( "produto/" . $p->codproduto . "/" . $p->urlseo );

			$precoPromocional = array ();

			$valorFinal = $p->valorproduto;

			if (($p->valorpromocional > 0) && ($p->valorpromocional < $p->valorproduto)) {
				$precoPromocional [] = array (
						"VALORANTIGO" => number_format ( $p->valorproduto, 2, ",", "." )
				);

				$valorFinal = $p->valorpromocional;
			}

			$nomefabricante = null;
			$filtrofabricante = array (
					"codfabricante" => $p->codfabricante
			);
			$fabricante	= $CI->ProdutoM->listaFabricates($filtrofabricante, TRUE);
			// print($fabricante->nomefabricante) ;

			if($fabricante){
				$nomefabricante = $fabricante->nomefabricante;
			}
			$codSku = null;
			$sku = $CI->SkuM->getPorProdutoSimples( $p->codproduto );
			if($sku){
				$codSku = $sku->codsku;
			}
			 
			$data ["BLC_LINHA"] [] = array (
					"URLFOTO" => $url,
					"FABRICANTE" => $nomefabricante,
					"CODSKU" => $codSku,
					"URLPRODUTO" => $urlFicha,
					"NOMEPRODUTO" => $p->nomeproduto,
					"BLC_PRECOPROMOCIONAL" => $precoPromocional,
					"VALOR" => number_format ( $valorFinal, 2, ",", "." )
			);

			
		}

		

		$html = $CI->parser->parse( "Produtos_Semelhantes", $data, TRUE );

		return $html;
	}
}