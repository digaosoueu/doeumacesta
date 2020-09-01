<table style="width: 100%; background-color: #2f343b">
<tr>
<td></td>
<td style="padding: 15px;">
<div style="padding:15px;
	max-width:600px;
	margin:0 auto;
	display:block; ">
	
<table style="width: 100%; background-color: #2f343b">
<tr>
<td><img src="<?php echo base_url("assets/loja/img/logo.png")?>" width="200" height="50" /></td>
<td>
<h6 style="margin:0!important;
	padding:0;font-weight:900; font-size: 14px; text-transform: uppercase; color:#2ba8db;text-align: right;">
<?php echo $NOMECLIENTE; ?></h6></td>
</tr>
</table>
</div>
</td>
<td></td>
</tr>
</table> 
 
<table style="width: 100%;">
<tr>
<td></td>
<td style="display:block!important;
	max-width:600px!important;
	margin:0 auto!important; /* makes it centered */
	clear:both!important; background-color: #ffffff">
<div style="padding:15px;
	max-width:600px;
	margin:0 auto;
	display:block; ">
<table>
<tr>
<td>
<h3 style="font-weight:500; font-size: 27px;">Muito Obrigado!</h3>

 
<table style="width: 100%;">
<tr><td>Alimento</td>
<td>Qtd</td>
<td>Valor</td>
</tr>


<?php foreach ($BLC_PRODUTOS as $item): ?>
<tr>
<td><?php echo $item["NOMEPRODUTO"]; ?></td>
<td><?php echo $item["QUANTIDADE"]; ?></td>
<td><?php echo $item["VALORTOTAL"]; ?></td>
</tr>
<?php endforeach; ?>


</table>
<br />
Valor doado em alimentos: <?php echo $TOTAL; ?>
<br />

<p style="font-size:14px;">A caridade é um ato nobre!
<br />
A caridade é o processo de somar alegrias, <br />
diminuir males, 
multiplicar esperanças e<br /> dividir a felicidade 
para que a Terra se<br /> realize na condição
do esperado Reino de Deus.<br />
<b>Hammed - Chico Xavier</b>
<br>
</p>

<table style="text-align:left;">
<tr>
<td>
<p style="font-size:12px;">
<strong>Leia com atenção!</strong><br>
A compra dos produtos são ilustrativas, você não receberá nenhum dos produtos comprados.
O pagamento realizado é para doação, 100% do valor arrecadado será revertido em cestas básicas e entregues a famílias carentes.
Veja em "Quem ajudamos".
</p>
</td>
</tr>
<tr>
<td>
<h5>Contato:</h5>
<p>Telefone: <strong>11 9 8992-2990</strong><br/>
Email: <strong>contato@doeumacesta.com.br</strong></p>
<p><a href="https://www.doeumacesta.com.br">www.doeumacesta.com.br</a></p>
<p><span style="font-size:16px;font-weight:normal">Leia com atenção!</span><br><span style="font-size:12px;font-weight:normal">A compra dos produtos são ilustrativas, você não receberá nenhum dos produtos comprados.<br>O pagamento realizado é para doação, 100% do valor arrecadado será revertido em cestas básicas e entregues a famílias carentes.<br>Veja em <a href="https://www.doeumacesta.com.br/caridade/index.php/conteudo/quemajudamos" style="color:#2f343b;">"Quem ajudamos"</a>.</span></p>
</td>
</tr>
</table> 
<span class="clear"></span>

</td>
</tr>
</table>
</div>
</td>
<td></td>
</tr>
</table> 
