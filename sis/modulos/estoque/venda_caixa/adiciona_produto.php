<?
	include("../../../_config.php");
	include("../../../_functions_base.php");
	include('_functions.php');

	$produto_id = $_POST['produto_id'];
	$cliente_id = $_POST['cliente_id'];
	$venda_id   = $_POST['venda_id'];
	$total      = $_POST['total'];
	
	if(!empty($produto_id)){
		$cont = 1;
	}
	$contador += $cont;
	$produto = mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id = ".$produto_id));
	$saldo= mysql_fetch_object(mysql_query("SELECT * FROM estoque_mov WHERE produto_id = '$produto_id' ORDER BY id DESC"));
	$conta_produto_fornecedor=mysql_result(mysql_query("SELECT COUNT(*) FROM produto_has_fornecedor WHERE fornecedor_id='$cliente_id' AND produto_id='$produto_id' AND vkt_id='$vkt_id'"),0,0);
	
	
	
	/* se o produto ainda não estiver relacionado com o fornecedor, insere na tabela produto_has_fornecedor */
	if($conta_produto_fornecedor<1){
		$query=mysql_query($trace="INSERT INTO produto_has_fornecedor SET fornecedor_id='$cliente_id', produto_id='$produto_id', vkt_id='$vkt_id'");
	} 	
	$select_item=mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_vendas_item WHERE produto_id='".$produto_id."' AND pedido_id='".$venda_id."'"));
	
	
	
	
	
	
	if(empty($select_item)){
		$query=mysql_query("INSERT INTO estoque_vendas_item SET vkt_id='$vkt_id', pedido_id='".$venda_id."', produto_id='".$produto_id."', qtd_pedida='1', valor_ini='".$produto->preco_venda."', fatorconversao='{$produto->conversao2}', unidade='$produto->unidade_embalagem'");
		$venda_item=mysql_insert_id();
	}else{
		$venda_item=$select_item->id;
	}
	if($select_item->qtd_pedida<=0){
			if($saldo->saldo/$produto->conversao2 < 0 )
				$qtd_origem = 0;
			else
				$qtd_origem = $saldo->saldo/$produto->conversao2;
	echo  "<tr><td width='150'>".utf8_encode($produto->nome)."<input type='hidden' name='produto_id[]' class='produto_id' value='$produto->id'/></td>
            <td width='60'><div id='class_qtd_origem'><input type='hidden' name='qtd_origem' value='".$qtd_origem."'></div> ".$qtd_origem." ".substr($produto->unidade_embalagem,0,2)."</td>
            <td width='60'>
           	  <input type='text'  name='qtd[]' class='qtd' value='1' onblur='direciona(this)' />
			  <input type='hidden' class='conversao' value='".$produto->conversao2."' />
			  <input type='hidden' class='unidade_embalagem' value='$produto->unidade_embalagem' />
           	</td>
            <td width='60'><span class='vlr'>".moedaUsaToBr($produto->preco_venda/$produto->conversao)."</span></td>
			<td width='60' align='right' class='v_total'>".moedaUsaToBr($produto->preco_venda/$produto->conversao)."</td>
           <td ><img src='../fontes/img/menos.png' width='18' height='18' onclick='removeItem(this)' class='remove'/><span style='display:none' id='item$cont' class='item'>$venda_item</span></td>
      </tr>";
	   $total+=$produto->preco_venda;
	  $total=moedaUsatoBr($total);
	  echo "<script>$('#vlrtotal').html('$total')</script>";
	}
?>