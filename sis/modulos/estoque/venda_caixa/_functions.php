<?


/**/
function checaSaldo($cliente_id,$conta_id){
	return @mysql_result(mysql_query("
	SELECT 
		saldo 
	FROM
		financeiro_movimento
	WHERE 
			cliente_id='$cliente_id' 
		AND 
			conta_id='$conta_id'
		AND
			`status`='1'
	ORDER BY
		data_movimento DESC
	LIMIT 1
	"),0,0);
}

function movimenta($cliente_id,$conta_id,$movimento_id,$entrada,$saida,$tipo_movimento){
	
	
	$saldo = checaSaldo($cliente_id,$conta_id);
	
	$novo_saldo = $entrada-$saida+$saldo;
	
	if(mysql_query($t="
	
	UPDATE 
		financeiro_movimento 
	SET 
		data_movimento=now(),
		entrada='$entrada',
		saida='$saida',
		saldo='$novo_saldo',
		movimentacao='$tipo_movimento',
		conta_id='$conta_id',
		`status`='1'
	WHERE
		id='$movimento_id'
	AND
		cliente_id='$cliente_id'
		
		")){
			
		return true	;	
	
	}else{
		
		return false;		
	}
	
}	

/**/

function cadastraVenda($cliente_id,$almoxarifado_id,$vkt_id){
	$query = mysql_query($t="INSERT INTO estoque_vendas SET 
	vkt_id='$vkt_id',
	fornecedor_id='".$cliente_id."', data_inicio='".date("Y-m-d")."', status='Em aberto', unidade_id='$almoxarifado_id'");
	//echo $t."<br>";
	echo mysql_error();
	$ultimo_id = mysql_insert_id();
	
	return $ultimo_id;
	//for($i=0;$i<sizeof($dados['produto_id']);$i++){
		//cadastraItem($vkt_id,$dados['produto_id'][$i],$ultimo_id,$dados['qtd'][$i],moedaBrtoUsa($dados['vlr'][$i]),$dados['unidade'][$i],$dados['conversao'][$i],$dados['conversao1']);
	//}
}

function cadastraItem($vkt_id,$dados){
	$query = mysql_query($t="INSERT INTO estoque_vendas_item SET vkt_id='$vkt_id', produto_id='".$dados['produto_id']."',pedido_id='".$dados['pedido_id']."',qtd_pedida='".$dados['qtd'].",valor_ini='".$dados['vlr'].",
	unidade='".$dados['unidade']."', fatorconversao='".$dados['conversao1']."', recebido='nao'");
	//echo $t."<br>";
	//echo mysql_error();
}

function finalizaVenda($venda_id){
	global $vkt_id;
	
	$finalizado = mysql_query("UPDATE estoque_vendas SET status='Finalizado', data_fim=NOW() WHERE id='$venda_id'");
	if($finalizado){
		//seleciona o pedido de venda
		$venda=mysql_fetch_object(mysql_query("SELECT * FROM estoque_vendas WHERE id='$venda_id'"));
		//query para selecionar os itens
		$vendas_itens = mysql_query("SELECT * FROM estoque_vendas_item WHERE vkt_id='$vkt_id' AND pedido_id='$venda_id'");
		//lista itens
		while($venda_item=mysql_fetch_object($vendas_itens)){
			//verifica o estoque
			$verifica_estoque=mysql_fetch_object(mysql_query("SELECT * FROM estoque_mov WHERE produto_id='$venda_item->produto_id' AND vkt_id='$vkt_id' ORDER BY id DESC"));
			$produto=mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE vkt_id='$vkt_id' AND id= '{$venda_item->produto_id}' "));
			
			if($verifica_estoque->id>0){
				$saldo=$verifica_estoque->saldo;
			}else{
				$saldo=0;
			}
			//echo "Saldo Anterior: ".$saldo."<br>";
			$saida = $venda_item->qtd_pedida*$venda_item->fatorconversao;
			//echo "Saida: ".$saida."<br>";
			//diminui do estoque
			$saldo_restante=$saldo-($venda_item->qtd_pedida*$venda_item->fatorconversao);
			//echo "Saldo Atual: ".$saldo_restante."<br>";
			//faz a movimentação
			mysql_query($t="INSERT INTO estoque_mov SET vkt_id='$vkt_id', produto_id='{$venda_item->produto_id}', saldo='$saldo_restante', saida='$saida', data_hora=NOW(), doc_tipo='venda', doc_id='$venda_id', almoxarifado_id='{$venda->unidade_id}' ");
			
		}
	}
}

function Pagamento($campos){ 
			//echo "Valores da parcela:<br> ";
			
			global $vkt_id;
					
			 
							
			$config = mysql_fetch_object(mysql_query(" SELECT * FROM estoque_config WHERE vkt_id = '$vkt_id' "));	
			
			/*Informações da Conta */
			$contaID       = $config->conta_id;
			$centroCustoID = $config->centro_custo_id;
			$plContaID     = $config->plano_conta_id;
			
			/*Informações da parcela*/
			$valorParcela = $campos['valor_parcela'];
			$desParcela   = $campos['descricao_parcela'];
			$dataVencimento = $campos['data_vencimento_parcela'];
			$forma_pagamento_parcela = $campos['forma_pagamento_parcela']; // recebe a forma de pagamento de cada parcela
			$campos['data_aprovacao'] = date('Y-m-d');
			
			$efetivar_movimentacao = $campos["efetivar_movimentacao"];
			
			
			$aMes = date('Y/m');
			
			
			//echo "<div id='conteudo'>aqui esta a afuncao</div>";
				for($i=0;$i < sizeof($valorParcela);$i++){
					
					$status = 0;
					$dtd_info_movimento = "";
					if($efetivar_movimentacao[$i] == 1){
						$status = 1;
						$dtd_info_movimento = "data_info_movimento=now(),";
					}
					
					$sql = " INSERT INTO financeiro_movimento 
						SET
							cliente_id        = '$vkt_id',
							conta_id		  = '$contaID',
							internauta_id	  = '".$campos['cliente_id']."',
							data_registro     = '".($campos['data_aprovacao'])."',
							data_vencimento	  = '".dataBrToUsa($dataVencimento[$i])."',
							ano_mes_referencia = '$aMes',
							descricao		  = '".$desParcela[$i]."',
							doc				  = '".$campos['id']."',
							forma_pagamento   = '".$forma_pagamento_parcela[$i]."',
							valor_cadastro    = '".moedaBRToUsa($valorParcela[$i])."',
							
							$dtd_info_movimento
							tipo              = 'receber',
							status            = '$status' ,
							origem_id         = '".$campos['id']."',
							origem_tipo       = 'venda' 
						";
						//echo $sql." ".mysql_error();
						mysql_query($sql);
						$movID = mysql_insert_id();
						
						/*- SQL PARA TABELA financeiro_centro_has_movimento -*/
						$sqlCentroAsMov = " INSERT INTO financeiro_centro_has_movimento
												SET
													movimento_id = '$movID',
													plano_id     = '$centroCustoID',
													valor        = '".moedaBRToUsa($valorParcela[$i])."'";
						mysql_query($sqlCentroAsMov); 
						//echo $sqlCentroAsMov;
						
						/*- SQL PARA A TABELA financeiro_plano_has_movimento -*/ 
						 $sqlPlanoAsMov = " INSERT INTO financeiro_plano_has_movimento 
												SET
													movimento_id = '$movID',
													plano_id     = '$plContaID',
													valor        = '".moedaBRToUsa($valorParcela[$i])."'
												";
						mysql_query($sqlPlanoAsMov);
						//echo $sqlPlanoAsMov;
						
						if($efetivar_movimentacao[$i] == 1){
							movimenta($vkt_id,$contaID,$movID,moedaBRToUsa($valorParcela[$i]),0,"financeiro");
						//movimenta($cliente_id,$conta_id,$movimento_id,$entrada,$saida,$tipo_movimento);
						}
				}
				
		/* UPDATE VENDA */
		mysql_query(" UPDATE estoque_vendas SET status = 'pago' WHERE id = '".$campos['id']."' ");
		
	}

function cancelavenda($venda_id){
	mysql_query("UPDATE estoque_vendas SET status='Cancelado' WHERE id='$venda_id'");

}

?>