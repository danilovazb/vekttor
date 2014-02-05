<?
function cadastraVenda($cliente_id,$almoxarifado_id,$vkt_id){
	$query = mysql_query($t="INSERT INTO estoque_vendas SET 
	vkt_id='$vkt_id',
	fornecedor_id='".$cliente_id."', data_inicio='".date("Y-m-d")."',unidade_id='$almoxarifado_id', status='Em aberto'");
	//echo $t."<br>";
	
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
		//seleciona o almoxarifado da venda
		$venda=mysql_fetch_object(mysql_query("SELECT unidade_id FROM estoque_vendas WHERE id='$venda_id'"));
		//query para selecionar os itens
		$vendas_itens = mysql_query("SELECT * FROM estoque_vendas_item WHERE vkt_id='$vkt_id' AND pedido_id='$venda_id'");
		//lista itens
		while($venda_item=mysql_fetch_object($vendas_itens)){
			//verifica o estoque
			$verifica_estoque=mysql_fetch_object(mysql_query("SELECT * FROM estoque_mov WHERE produto_id='$venda_item->produto_id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));
			$produto=mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE vkt_id='$vkt_id' AND id= '{$venda_item->produto_id}' "));
			
			if($verifica_estoque->id>0){
				$saldo=$verifica_estoque->saldo;
			//echo "Saldo Anterior: ".$saldo."<br>";
			//diminui do estoque
			$saida  = $venda_item->qtd_pedida*$venda_item->fatorconversao;
			//echo "Saida: ".$saida."<br>";
			$saldo_restante=$saldo-$saida;
			//echo "Novo Saldo: ".$saldo_restante."<br>";
			//faz a movimentação
			mysql_query($t="INSERT INTO estoque_mov SET vkt_id='$vkt_id', produto_id='{$venda_item->produto_id}', saldo='$saldo_restante', saida='$saida', data_hora=NOW(), doc_tipo='venda', doc_id='$venda_id', almoxarifado_id='$venda->unidade_id' ");
			}
		}
	}
}

function cancelavenda($venda_id){
	mysql_query("UPDATE estoque_vendas SET status='Cancelado' WHERE id='$venda_id'");

}
?>