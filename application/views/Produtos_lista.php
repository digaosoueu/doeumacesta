 <!--Catalog Grid-->
      <section class="catalog-grid">
      	<div class="container">
      	{MENSAGEM_SISTEMA_ERRO}
        	{MENSAGEM_SISTEMA_SUCESSO}
        	<h2 class="primary-color">Alimentos</h2>
          <div class="row">
          	<!--Tile-->
          	
          	{BLC_LINHA}
          	{BLC_COLUNA}
          	<div class="col-lg-3 col-md-4 col-sm-6" style="height:330px;">
	            <div class="tile">
	              	{BLC_PRECOPROMOCIONAL}	              	
	              	<div class="price-label old-price">R$ {VALORANTIGO}</div> 
	              	{/BLC_PRECOPROMOCIONAL}
	                <div class="price-label">R$ {VALOR}</div>
	                <a href="javascript:void(0)" title="{NOMEPRODUTO}"><img src="{URLFOTO}" alt="{NOMEPRODUTO}"/></a>             	
	                <div class="footer">
	                	<a href="javascript:void(0)">{NOMEPRODUTO}</a><br>
	                	{MOSTRALINKCESTA}
	                	<span><a href="<?php echo site_url("conteudo/cestabasicacompleta")?>">Ver Itens da cesta</a></span>
	                	{/MOSTRALINKCESTA}
	                  <span>{FABRICANTE}</span>
	                  <div class="tools">
	                  	
	                    <!--Add To Cart Button-->
	                    <a class="add-cart-btn" href="javascript:void(0);" onclick="addCard({CODSKU});" data-toggle="modal" data-target="#modalCarrinho"><span>+ carrinho</span><i class="icon-shopping-cart"></i></a>
	                    <!--Share Button-->
	                    <div class="share-btn">
	                    	<div class="hover-state">
	                      	<a class="fa fa-facebook-square" href="#"></a>
	                        <a class="fa fa-twitter-square" href="#"></a>
	                        <a class="fa fa-google-plus-square" href="#"></a>
	                      </div>
	                      <i class="fa fa-share"></i>
	                    </div>
	                    <!--Add To Wishlist Button-->
	                    
	                  </div>
	                </div>
	              </div>
            	</div>
                
            	{/BLC_COLUNA}
            	{/BLC_LINHA}
          
            
          </div>
        </div>
      </section><!--Catalog Grid Close-->