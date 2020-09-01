<span id="carregaCarrinho">
<!--Breadcrumbs-->
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>">Home</a></li>
        <li>Carrinho</li>
      </ol><!--Breadcrumbs Close-->
      
      <!--Shopping Cart-->
      <section class="shopping-cart">
      
      	<div class="container" >
        	<div class="row">
          
          	<div>
	          	<!--Items List-->
	          	<div class="col-lg-9 col-md-9">
	                
	                <h2 class="title">Carrinho{BLC_SEMPRODUTOS} Vazio!{/BLC_SEMPRODUTOS}</h2>
	               
	            	
	            	<table class="items-list">
	              	<tr>
	                  <th>&nbsp;</th>
	                  <th>Produto</th>
	                  <th>Preço</th>
	                  <th>Quantidade</th>
	                  <th>Total</th>
	                </tr>
	                <!--Item-->                
	                 {BLC_PRODUTOS}
	                <tr class="item">
	                	<td class="thumb">
	                		<a href="javascript:void(0)">
	                			<img src="{URLFOTO}" alt="{NOMEPRODUTO}" width="120" />
	                		</a>
	                	</td>
	                  <td class="name"><a href="javascript:void(0)">{NOMEPRODUTO}</a></td>
	                  <td class="price">{VALOR}</td>
	                  <td class="qnt-count">
	                    <a class="incr-btn" href="javascript:void(0)" onclick="javascript:ADRCarrinho({CODSKU},'diminuir')">-</a>
	                    <input class="quantity form-control" type="text" value="{QUANTIDADE}">
	                    <a class="incr-btn" href="javascript:void(0)" onclick="javascript:ADRCarrinho({CODSKU},'adicionar')">+</a>
	                  </td>
	                  <td class="total">{VALORTOTAL}</td>
	                  <td class="delete"><i class="icon-delete" onclick="javascript:ADRCarrinho({CODSKU},'remover')"></i></td>
	                </tr>
	                 {/BLC_PRODUTOS}
	              </table>
	             
	            </div>
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
                  <a href="<?php echo site_url(); ?>" class="btn btn-primary btn-sm btn-block">Continuar Comprando</a>
                  <a href="<?php echo site_url("checkout/pagamento"); ?>" class="btn btn-success btn-block">Escolher Pagamento</a>
                </div>
               
              </form>
              {/BCL_TOTALCARRINHO}
            </div>
          </div>
        </div>
      </section><!--Shopping Cart Close-->
    
  </span>
      
      
      
    