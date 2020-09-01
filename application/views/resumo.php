<!--Breadcrumbs-->
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">Home</a></li>
        <li>Resumo</li>
      </ol><!--Breadcrumbs Close-->
      
      <!--Shopping Cart-->
      <section class="shopping-cart">
      <div id="loaderCarregando" style="display:none; margin-left: 100px;"></div>
      	<div class="container" id="carregaCarrinho">
        	<div class="row">
          
          	<div>
	          	<!--Items List-->
	          	<div class="col-lg-9 col-md-9">
	          			                
	                {DETALHESPAGAMENTO}
	            	{MSG}
	            	<div style="margin-bottom:30px;">
	            		
	            			{DADOS}            			
	            			<input type="hidden" value="{COD}" id="codcarrinho">
	            			{BTNPG} 
	            		
	            	</div>
	            	{/DETALHESPAGAMENTO}
	            	<table class="items-list">
						<tr>
							<th>Codigo:</th>
							<th>Forma Pagamento:</th>
							<th>Valor:</th>
							
						</tr>
						<tr>
							<td>{CODCARRINHO}</td>
							<td>{NOMEFORMAPAGAMENTO}</td>
							<td>{VALORFINALCOMPRA}</td>
						</tr>						
						
					</table> 	
	            	
	            	
	            	<table class="items-list">
	              	<tr>	                  
	                  <th>Produto</th>
	                  <th>Preço</th>
	                  <th>Quantidade</th>
	                  <th>Total</th>
	                </tr>
	                <!--Item-->                
	                {BLC_DADOS}
	                <tr class="item">	                	
	                  <td class="name"><a href="javascript:void(0)">{NOMEPRODUTO}</a></td>	 
	                  <td class="price">{VLRUN}</td>                 
	                  <td class="qnt-count">{QTD}</td>	                  
	                  <td class="total">{VLRTOTAL}</td>	                  
	                </tr>
	                {/BLC_DADOS}
	              </table>
	              
	            </div>
            </div>
            <!--Sidebar-->
            <div class="col-lg-3 col-md-3">
            
            <table>            
	            <!-- <tr>
	            	<td>
            		<h3>Dados do Pagamento</h3>
            			
	            		{DETALHESPAGAMENTO}
	            			{DADOS}            			
	            			<input type="hidden" value="{COD}" id="codcarrinho">
	            			{BTNPG} 
	            		{/DETALHESPAGAMENTO}
	            		{LINK_BOLETO}
            				<a href="{URLBOLETO}" class="btn btn-success" target="_blanck" style="width: 250px">imprimir boleto</a><br><br>
            				<button type="button" class="btn btn-primary" onclick="BtnPagamentoPagSeguro();">outro pagamento</button>
            			{/LINK_BOLETO}
	            	</td>
	            </tr> -->
	            <tr>
	            	<h3>Leia com atenção!<h3>
	            	<span style="font-size:12px;font-weight:normal">A compra dos produtos são ilustrativas, você não receberá nenhum dos produtos
	            	comprados.<br>
	            	O pagamento realizado é para doação, 100% do valor arrecadado será revertido em cestas básicas e 
	            	entregues a familias carentes.<br>
	            	Veja em <a href="<?php echo site_url("conteudo/quemajudamos") ?>">"Quem ajudamos"</a>.</span>
	            	</td>
	            </tr>
            </table>           
            
            
            </div>
          </div>
        </div>
      </section><!--Shopping Cart Close-->
      
   
      <div class="modal fade" id="processandopagamento">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
	        <h4 class="modal-title" id="textAdicionar">Processando...</h4>
	      </div>
	     </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div>
	
    