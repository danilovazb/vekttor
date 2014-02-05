<?
	include("../../../_config.php");
	include("../../../_functions_base.php");
	include('_functions.php');

	global $vkt_id;
	
	$produto_id=$_POST['produto_id'];
	$fornecedor_id=$_POST['fornecedor_id'];
	$pedido_id=$_POST['compra_id'];
	$unidade_id=$_POST['unidade_id'];
	
		
	if($_POST['acao']=='duplica_compra'){
	
		$compra_antiga_id = $_POST['compra_id'];
		
		//seleciona a compra antiga
		$compra_antiga = mysql_fetch_object(mysql_query("SELECT * FROM estoque_consumos WHERE id='$compra_antiga_id'"));
		
		//seleciona os itens da compra antiga
		$itens_compra_antiga = mysql_query("SELECT * FROM estoque_consumos_item WHERE pedido_id='$compra_antiga_id'");
		
		//adiciona um dia ao atual
		$data_chegada_prevista = mysql_result(mysql_query("SELECT DATE_ADD(CURDATE(), INTERVAL 1 DAY)"),0,0);		
		
		//insere nova compra
		mysql_query($t="INSERT INTO estoque_consumos SET
					vkt_id = '$vkt_id',
					fornecedor_id ='$compra_antiga->fornecedor_id',
					unidade_id    ='$compra_antiga->unidade_id',
					data_inicio   = NOW(),
					data_chegada_prevista = '$data_chegada_prevista',
					status='Em aberto'");		
		
		//recebe id da nova compra
		$nova_compra_id = mysql_insert_id();
		
		//insere itens da nova compra
		while($item_compra_antiga = mysql_fetch_object($itens_compra_antiga)){
		
			mysql_query($t="INSERT INTO
							estoque_consumos_item
						SET
							vkt_id     ='$vkt_id',
							pedido_id  ='$nova_compra_id',
							produto_id ='$item_compra_antiga->produto_id',
							qtd_pedida ='$item_compra_antiga->qtd_pedida',
							valor_ini  ='$item_compra_antiga->valor_ini',
							marca      ='$item_compra_antiga->marca',
							unidade    ='$item_compra_antiga->unidade',
							fatorconversao = '$item_compra_antiga->fatorconversao',
							fatorconversao2 = '$item_compra_antiga->fatorconversao2'  
			");
						
		}
		
		
		echo $nova_compra_id."|".$compra_antiga->unidade_id."|".$compra_antiga->fornecedor_id;
		
		exit();
	
	}
	
	if($produto_id>0){
	
		$produto = mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id = ".$produto_id));
	
	}
	
	
	$conta_produto_fornecedor=mysql_result(mysql_query("SELECT COUNT(*) FROM produto_has_fornecedor WHERE fornecedor_id='$fornecedor_id' AND produto_id='$produto_id' AND vkt_id='$vkt_id'"),0,0);
	
	if($conta_produto_fornecedor<1){
		$query=mysql_query($trace="INSERT INTO produto_has_fornecedor SET fornecedor_id='$fornecedor_id', produto_id='$produto_id', vkt_id='$vkt_id'");
		//echo $trace;
	}
	
	$select_item=mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_consumos_item WHERE produto_id='".$produto_id."' AND pedido_id='".$pedido_id."'"));	
	//echo $t."<br>";
	 $qtd_estoque = mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_mov WHERE almoxarifado_id = '".$unidade_id."' AND produto_id='".$produto_id."' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));
	//echo $t."<br>";
	if($qtd_estoque->saldo > 0){
		$qtd_estoque_embalagem = $qtd_estoque->saldo/$produto->conversao2;
		$qtd_estoque = MoedaUsaToBr($qtd_estoque_embalagem)." ".substr($produto->unidade_embalagem,0,2);
	}else{
		$qtd_estoque="0,00";
	}
	
	if($select_item->qtd_pedida<=0){
	echo "<tr  id='l".$_POST[nlinhas]."'>
			<td width='80'>
				".utf8_encode($produto->nome)."
				<input type='hidden' name='produto_id[]' class='produto_id' value='$produto->id'/>
		 	</td>
		 	<td width='50'>
		 		<input type='text'  name='marca[]' class='marca' value='' onblur='direciona(this)'>
		 	</td>
			<td width='70'>
		 		$qtd_estoque
		 	</td>
		 	<td width='40'>
				<input type='text'  name='qtd[]' class='qtd' value='' onblur='direciona(this)' sonumero='1'>
		 	</td>
		 	<td width='80'>
		 		<select name='unidade[]' class='und' onchange='direciona(this)' >
              		<option  ut = 'compra' value='".$produto->unidade."'>$produto->unidade - $produto->conversao</option>
              		<option ut = 'embalagem' value='$produto->unidade_embalagem'>$produto->unidade_embalagem - $produto->conversao2</option>
              		<option ut = 'uso' value='$produto->unidade_uso'>$produto->unidade_uso</option>
            		<option value='editar_fator'>Editar Fatores</option>
					</select>
					<input type='hidden' name='conversao' class='conversao' value='$produto->conversao' id='conversao_$produto->id'/>
            		<input type='hidden' name='conversao1' class='conversao2' value='$produto->conversao2' id='conversao2_$produto->id'/>
					
		 	</td>
			<td width='70'><input type='text' name='vlr[]' class='vlr' value='".moedaUsaToBr($produto->custo)."' onblur='direciona(this)' sonumero='1'/></td>
			 <td width='60' align='right' class='cz'>".moedaUsaToBr($produto->custo)."</td>
            
		 <td width='60' align='right' class='cz'><span class='qtd_unidade'>";
			  
            	if($pedido_item->qtd_pedida>0){
				if($ut=='compra'){
					//echo $ut;
					$qtd_unidade   = $pedido_item->qtd_pedida;;
					$qtd_embalagem = $qtd_unidade*$pedido_item->fatorconversao;;
					$qtd_uso	   = $qtd_unidade*$pedido_item->fatorconversao2*$pedido_item->fatorconversao;
		
					$vlr_unidade   = $pedido_item->valor_ini;
					$v_embalagem   = $vlr_unidade/$pedido_item->fatorconversao;
					$v_uso		   = $v_embalagem/$pedido_item->fatorconversao2;
					//echo $vlr_unidade."<br>";
				}
				if($ut=='embalagem'){
				//	echo $ut;
					$qtd_embalagem 	= $pedido_item->qtd_pedida;
					$qtd_unidade 	= $pedido_item->qtd_pedida/$pedido_item->fatorconversao;
					$qtd_uso		= $pedido_item->qtd_pedida*$pedido_item->fatorconversao2;
		
					$v_embalagem	= $pedido_item->valor_ini;
					$vlr_unidade 	= $v_embalagem*$pedido_item->fatorconversao;
					$v_uso			= $v_embalagem/$pedido_item->fatorconversao2;
					//echo $vlr_unidade."<br>";
				}
				if($ut=='uso'){
					$qtd_uso		= $pedido_item->qtd_pedida;
					$qtd_embalagem 	= $qtd_uso*$pedido_item->fatorconversao2;
					$qtd_unidade 	= $pedido_item->qtd_pedida/$pedido_item->fatorconversao;
		
					$v_uso			= $pedido_item->valor_ini;
					$v_embalagem	= $v_uso*$pedido_item->fatorconversao2;
					$vlr_unidade 	= $v_embalagem*$pedido_item->fatorconversao;
					//echo $vlr_unidade."<br>";
				}
				}
				
			echo $qtd_unidade."</span>".substr($produto->unidade,0,2);
			echo "</td>";
			echo "<td width='60' align='right' class='cz v_compra'>".moedaUsatoBr($vlr_unidad)."</td>
            <td width='70' align='right' class='cz'><span class='qtd_embalagem'>".moedaUsaToBr($qtd_embalagem)."</span>".$produto->unidade_embalagem."</td>
            <td width='60' align='right' class='cz v_embalagem'>".moedaUsatoBr($v_embalagem)."</td>
            <td width='57' align='right' class='cz'><span class='qtd_uso'>".moedaUsatoBr($v_uso)."</span>".$produto->unidade_uso."</td>
            <td width='50' align='right' class='cz v_uso'>".moedaUsatoBr($v_uso)."</td>
            <td width='60' align='right' class='v_total'>".moedaUsatoBr($pedido_item->valor_ini)."</td>
            <td ><img src='../fontes/img/menos.png' width='18' height='18' onclick='removeItem(this)' class='remove'/><span style='display:none' id='item$cont' class='item'></span></td>
            
      </tr>";
	}
?>