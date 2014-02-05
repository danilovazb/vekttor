<?
	include("../../../_config.php");
	include("../../../_functions_base.php");
	
	global $vkt_id;
	$acao = $_POST['acao'];
	
	if($acao=="duplica_transferencia"){
		
		$transferencia_antiga_id = $_POST['transferencia_id'];
		
		//seleciona dados da transferencia antiga
		$transferencia_antiga = mysql_fetch_object(mysql_query("SELECT * FROM estoque_transferencia WHERE id='$transferencia_antiga_id'"));
		
		//seleciona os itens da transferencia antiga
		$itens_transferencia_antiga = mysql_query("SELECT * FROM estoque_transferencia_item WHERE transferencia_id='$transferencia_antiga_id'");
		
		//insere nova transferencia
		mysql_query("INSERT INTO 
						estoque_transferencia
					SET
						vkt_id='$vkt_id',
						unidade_id_origem  = '$transferencia_antiga->unidade_id_origem',
						unidade_id_destino = '$transferencia_antiga->unidade_id_destino',
						data_inicio        = NOW(),
						status             = '0'
						");
		
		//recebe id da nova transferência
		$nova_transferencia_id = mysql_insert_id();
		
		while($item_transferencia = mysql_fetch_object($itens_transferencia_antiga)){
		
			mysql_query(
			$t="
				INSERT INTO
					estoque_transferencia_item
				SET
					vkt_id           = '$vkt_id',
					transferencia_id = '$nova_transferencia_id',
					produto_id       = '$item_transferencia->produto_id',
					qtd_enviada      = '$item_transferencia->qtd_enviada',
					unidade          = '$item_transferencia->unidade',
					fatorconversao   = '$item_transferencia->fatorconversao',
					recebido         = 'nao'
			"
				
			);
			
			
		
		
		}
		//echo $retorno;
		echo $nova_transferencia_id."|".$transferencia_antiga->unidade_id_origem."|".$transferencia_antiga->unidade_id_destino;
				
	}
	
	if($acao=='consulta_produto'){
		$produto_id = $_POST['produto_id'];
		
		$produto = mysql_fetch_object(mysql_query($t="SELECT * FROM produto WHERE id='$produto_id'"));
		
		$t="$produto->unidade_embalagem
			<input type='hidden' name='conversao_embalagem_novo_produto' id='conversao_embalagem_novo_produto' value='".substr($produto->unidade_embalagem,0,2)." ".qtdUsaToBr($produto->conversao2).' '.substr($produto->unidade_uso,0,2)."' />
			<input type='hidden' name='unidade_uso_novo_produto' id='unidade_uso_novo_produto' value='".substr($produto->unidade_uso,0,2)."' />";
		echo $t;
	}
?>