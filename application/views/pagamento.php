 <!--Breadcrumbs-->
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">Home</a></li>
        <li>pagamento</li>
      </ol><!--Breadcrumbs Close-->
      
      <!--Checkout-->
      <section class="checkout">
      	<div class="container">
        	
          <!--Expandable Panels-->
        	<div class="row">
            <div class="col-lg-9 col-md-9">
            {MENSAGEM_SISTEMA_ERRO}
        	{MENSAGEM_SISTEMA_SUCESSO}
            	<h2>Pagamento</h2>
            	<input type="hidden" id="codcarrinho" value="{codcarrinho}">
            	  <!--Tabs Widget-->
			      <section class="tabs-widget">
			        <!-- Nav tabs -->
			        <ul class="nav nav-tabs">
			        {BLC_ABAS}
			          <li{ATIVO}><a href="#{LINK}" data-toggle="tab">{NOMEFORMAPAGAMENTO}</a></li>
			        {/BLC_ABAS}
			        </ul>
			        <div class="tab-content">
			        
			        {BLC_FORMAPAGAMENTO}
			          <div class="tab-pane fade {ATIVE}" id="{ID}">
			          	<div class="container">
			            	<div class="row">
			              	<div class="col-lg-7 col-md-7 col-sm-7">
			                    <div class="shop-filters">
				                    <section class="filter-section">
					                    
						                    <label>
						                    <input type="radio" value="{CODFORMAPAGAMENTO}" name="codformapagamento" />R$ {VALOR}{DESCRICAO}
						                    </label>
					                    
					                 </section>
			                     </div>
			                  
			                </div>
			              	
			              </div>
			              
			            </div>
			          </div>
			         {/BLC_FORMAPAGAMENTO}
			        </div>
			      </section>
			      
			      
            </div>
            <!--Sidebar-->
            <div class="col-lg-3 col-md-3">
	            {BCL_TOTALCARRINHO}
	              <h3>Total do carrinho</h3>
	              <form class="cart-sidebar">
	              	<div class="cart-totals">
	                	<table>
	                  	<tr>
	                    	<td>subtotal</td>
	                      <td class="total align-r">R$ {SUBTOTALCARRINHO}</td>
	                    </tr>
	                  	<tr class="devider">
	                    	<td>Taxas</td>
	                      <td class="align-r">R$ 0,00</td>
	                    </tr>
	                  	<tr>
	                    	<td>total</td>
	                      <td class="total align-r">R$ {TOTALCARRINHO}</td>
	                    </tr>
	                  </table>
	                 
	                  <input class="btn btn-success btn-block" id="btn-finalizar" type="button" name="place-order" value="Finalizar" onclick="javascript:alert('Escolha uma forma de pagamento')">
	                </div>
	               
	              </form>
	              {/BCL_TOTALCARRINHO}
            </div>
          </div>
          
          <!--Checkout Form-->
          
        </div>
      </section><!--Checkout Close-->
     
  <script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script> 
      
      