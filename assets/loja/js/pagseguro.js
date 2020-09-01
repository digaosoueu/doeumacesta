$(document).ready(function() {	
	
	
});


function BtnPagamentoPagSeguro(){
	
		var cod = "";
		if($("#codcarrinho").val().length > 0 ){cod = $("#codcarrinho").val();}
		
	    $("#processandopagamento").modal('toggle');	
		$.ajax({
			type: "POST",
			url: UrlSite + "PagSeguro/pagamentoPagSeguro/" + cod,
			contentType: "Content-Type; application/x-www-form-urlencoded; charset=utf-8",
			success: function(response) {
			  
				//alert(response);
				if(response != "Erro"){					
					
					PagSeguroLightbox(response);
					$("#processandopagamento").modal('hide');
				}
								
			},
			failure: function(msg) {
				alert(msg);
			}
		});
	
}
