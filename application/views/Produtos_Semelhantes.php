<!--Catalog Grid-->
      <section class="catalog-grid">
      	<div class="container">
        	<h2 class="primary-color">+ Alimentos</h2>
          <div class="row">
          	
          
          	{BLC_LINHA}
          	<div class="col-lg-3 col-md-4 col-sm-6">
	            <div class="tile">
	              	{BLC_PRECOPROMOCIONAL}	              	
	              	<div class="price-label old-price">R$ {VALORANTIGO}</div> 
	              	{/BLC_PRECOPROMOCIONAL}
	                <div class="price-label">R$ {VALOR}</div>
	                <a href="javascript:void(0)" title="{NOMEPRODUTO}"><img src="{URLFOTO}" alt="{NOMEPRODUTO}"/></a>             	
	                <div class="footer">
	                	<a href="javascript:void(0)">{NOMEPRODUTO}</a>
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
            	{/BLC_LINHA}
          	
          </div>
        </div>
      </section><!--Catalog Grid Close-->