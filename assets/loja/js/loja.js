
var UrlSite = "http://localhost/caridade/index.php/";
$(document).ready(function() {	
	
	

	$('.iCheck-helper').click(function(){
		var $button = $(this);
		var oldValue = $button.parent().find("input").val();
		//alert(oldValue);
		gravarCodPagamento(oldValue);
	});

	$(document).on('submit', '.ajax-form', function (e) {
		
		var responseHolder = $('.response-holder');
	    // Stop form submitting
	    e.preventDefault();
	    var form = $(this),
			responseHolder = form.find('.response-holder');
			inputs = form.find('input[type=text],input[type=email], input[type=password], textarea');
	        formdata = form.serializeArray();
	
	    responseHolder.removeClass('error');
	    responseHolder.addClass('success').html('<div class="inner">Enviando...</div>');
	    
	
	    // Data validation here?
	    $.ajax({
	        url: UrlSite + "FuncoesAjax/EnviaEmailContato/",
	        type: 'POST',
	        data: formdata,
	        success: function(response) {	        	
	           
	            if (response == "OK") {
	            	
	               $('input[type=text],input[type=email], input[type=password], textarea').val("");
	            	responseHolder.addClass('success').html('<div class="inner">Mensagem enviada com sucesso</div>');
					inputs.removeClass('error');
					
	            } else {
	            	responseHolder.addClass('error').html('<div class="inner">' + response + '</div>');
					inputs.addClass('error');
	            }
	        },
			failure: function(msg) {
				alert(msg);
			}
	    });
	    
});
	
	
	if($("#datanascimentocomprador").length > 0){$('#datanascimentocomprador').mask('99/99/9999');}
	if($("#telefonecomprador").length > 0){$('#telefonecomprador').mask('99-9999-9999');}
	if($("#celularcomprador").length > 0){$('#celularcomprador').mask('99-99999-9999');}
	if($("#cpfcomprador").length > 0){$('#cpfcomprador').mask('999.999.999-99');}
	//$('#datanascimentocomprador').mask('99/99/9999');
	
	CarregaMiniCar();
	
});



function MostrarFormConEsq(Tipo, local){	

	$("#login" + local + " #CPFesquecicomprador").val("");
	$("#login" + local + " #novasenhacomprador").val("");
	
	if(Tipo == "esq"){
		
		$("#login" + local + " #NovaConta").hide();		
		$("#login" + local + " #EsqueciMinhaSenha").show();
		$("#novasenha").hide();		
		$("#btn-success").val('Recuperar');
	}
	
	if(Tipo == "voltar"){	
		
		$("#login" + local + " #NovaConta").show();
		$("#login" + local + " #EsqueciMinhaSenha").hide();
		$("#novasenha").hide();
		$("#btn-success").val('Logar');
	}
}

function CarregaMiniCar(){
	
	$.ajax({
		type: "POST",
		url: UrlSite + "FuncoesAjax/carregaMiniCar/",
		contentType: "Content-Type; application/x-www-form-urlencoded; charset=utf-8",
		success: function(response) {
		  
			
			$("#CarregaMiniCar").html(response);
			
		},
		failure: function(msg) {
			alert(msg);
		}
	});
	
}

function addCard(CODSKU){
	//
	$("#footerModalCarrinho").hide();
	$("#textAdicionar").html("Adicionando...");
	 $.ajax({
			type: "POST",
			url: UrlSite + "FuncoesAjax/addCard/" + CODSKU,
			contentType: "Content-Type; application/x-www-form-urlencoded; charset=utf-8",
			success: function(response) {
			  
				//alert(response);
				if(response == "OK"){
					
					$("#textAdicionar").html("Produto adicionado em seu carrinho!");
					$("#footerModalCarrinho").show();
					CarregaMiniCar();
					
				}else{
					$("#textAdicionar").html(response);
				}
				
			},
			failure: function(msg) {
				alert(msg);
			}
		});
	
}

function ADRCarrinho(CODSKU,tipo){	//
	
	var controller = "";
	
	if(tipo == "adicionar"){
		controller = "adicionaCard";
	}
	
	if(tipo == "diminuir"){
		controller = "diminuiCard";
	}
	
	if(tipo == "remover"){
		controller = "removerCard";
	}
	
	if(controller != ""){	
	
		//$("#carregaCarrinho").hide();
		//$("#loaderCarregando").show();
		$("#carregaCarrinho").html("<div style='margin:auto; width:100px;'><img src='../assets/img/loja/ajax-loader-2.gif' width='150px'></div>");
		
		 $.ajax({
				type: "POST",
				url: UrlSite + "FuncoesAjax/" + controller + "/" + CODSKU,
				contentType: "Content-Type; application/x-www-form-urlencoded; charset=utf-8",
				success: function(response) {
				  
					//alert(response);
					//if(response == "OK"){
						
						//$("#loaderCarregando").hide();
						//$("#carregaCarrinho").show();
						$("#carregaCarrinho").html(response);
						CarregaMiniCar();
						
					//}else{
						//$("#textAdicionar").html(response);
					//}
					
				},
				failure: function(msg) {
					alert(msg);
				}
			});
	}
	
}

function gravarCodPagamento(COD){
	//
	
	 $.ajax({
			type: "POST",
			url: UrlSite + "FuncoesAjax/gravarCodPagamento/" + COD,
			contentType: "Content-Type; application/x-www-form-urlencoded; charset=utf-8",
			success: function(response) {
			  
				//alert(response);
				//console.log(COD);
				//if(COD == 1){
					$("#btn-finalizar").attr("onclick", "javascript:location.href='" + UrlSite + "checkout/finalizar/'");
				//}
				//else{
					//$("#btn-finalizar").attr("onclick", "CarregaPagamentoPagseguro();");
				//}
				
								
			},
			failure: function(msg) {
				alert(msg);
			}
		});
	
}

function CadastrarNews(){
	
	var Email = $("#EmailNews").val();
	var Nome  = $("#NomeNews").val();
	$("#RespostaNews").show();
	$("#RespostaNews").html("Gravando...");
	
	if(Email != ""){
		
		$.ajax({
			type: "GET",
			url: UrlSite + "FuncoesAjax/CadastrarNews/?Email=" + Email + "&Nome=" + Nome,
			contentType: "Content-Type; application/x-www-form-urlencoded; charset=utf-8",
			success: function(response) {
			  
				//alert(response);
				
				$("#RespostaNews").html("Cadastro efetuado com Sucesso!");
				$("#EmailNews").val("");
				$("#NomeNews").val("");
								
			},
			failure: function(msg) {
				alert(msg);
			}
		});
		
	}else{
		
		
		$("#RespostaNews").html("Preencha todos os dados");
	}
	
}

function BtnPagamento(cod, tipo){
	
	if(tipo == "NaoVerificar"){
		PagSeguroLightbox(cod);
	}else{
		
		$.ajax({
			type: "POST",
			url: UrlSite + "FuncoesAjax/verificaCodPagSeguro/" + cod,
			contentType: "Content-Type; application/x-www-form-urlencoded; charset=utf-8",
			success: function(response) {
			  
				//alert(response);
				if(response != "Erro"){					
					
					PagSeguroLightbox(response);
				}
								
			},
			failure: function(msg) {
				alert(msg);
			}
		});
	}
	
	
}
function CarregaPagamentoPagseguro(codcarrinho){	
	
	$("#processandopagamento").modal('toggle');
	 $.ajax({
			type: "POST",
			url: UrlSite + "PagSeguro/pagamentoPagSeguro/" + codcarrinho,
			contentType: "Content-Type; application/x-www-form-urlencoded; charset=utf-8",
			success: function(response) {
			  
				//alert(response);
				if(response != "Erro"){
					
					//$("#BtnRealizaPamanto").html("<button type='button' class='btn btn-primary' onclick='BtnPagamento(" + response + ")'>Realizar pagamento</button>");
					$("#processandopagamento").modal('hide');
					PagSeguroLightbox(response);
				}
								
			},
			failure: function(msg) {
				alert(msg);
			}
		});
	
}