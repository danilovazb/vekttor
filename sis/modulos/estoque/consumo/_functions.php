<?
function cadastraPedido($estoque_id,$vkt_id){
	$data_padrao = mysql_fetch_object(mysql_query("SELECT DATE_ADD(CURDATE(), INTERVAL 2 DAY) as data_padrao"));
	$query = mysql_query($t="INSERT INTO estoque_consumos SET vkt_id='$vkt_id',fornecedor_id='0', data_inicio='".date("Y-m-d")."', status='Em aberto', obs_pedido='', obs_chegada='',  unidade_id='$estoque_id', data_chegada_prevista='$data_padrao->data_padrao'");
	//echo $t;
	//echo mysql_error();
	$ultimo_id = mysql_insert_id();
	
	return $ultimo_id;
	//for($i=0;$i<sizeof($dados['produto_id']);$i++){
		//cadastraItem($vkt_id,$dados['produto_id'][$i],$ultimo_id,$dados['qtd'][$i],moedaBrtoUsa($dados['vlr'][$i]),$dados['unidade'][$i],$dados['conversao'][$i],$dados['conversao1']);
	//}
}

function cadastraItem($vkt_id,$dados){
	$query = mysql_query($t="INSERT INTO estoque_consumos_item SET vkt_id='$vkt_id', produto_id='".$dados['produto_id']."',pedido_id='".$dados['pedido_id']."',qtd_pedida='".$dados['qtd'].",valor_ini='".$dados['vlr'].",
	unidade='".$dados['unidade']."', fatorconversao='".$dados['conversao1']."', recebido='nao'");
	//echo $t."<br>";
	//echo mysql_error();
}

function movimenta_estoque($consumo_id,$almoxarifado_id){
	global $vkt_id;
	global $usuario_id;	
	
	//seleciona os itens do consumo
	$itens_consumo = mysql_query("SELECT * FROM estoque_consumos_item WHERE vkt_id='$vkt_id' AND pedido_id='$consumo_id'"); 
	
	while($item_consumo = mysql_fetch_object($itens_consumo)){
		//seleciona o saldo atual do produto
		$saldo_atual = mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_mov WHERE vkt_id='$vkt_id' AND produto_id='$item_consumo->produto_id' AND almoxarifado_id='$almoxarifado_id' ORDER BY id DESC LIMIT 1"));
		echo $t."<br>";
		echo $saldo_atual->saldo;
		//verifica em qual unidade o produto foi pedido {compra, embalagem, uso} e calcula novo saldo de em quantidade de uso
		if($item_consumo->unidade_tipo=="compra"){
			$novo_saldo = $item_consumo->qtd_pedida*$item_consumo->fatorconversao*$item_consumo->fatorconversao2;
		}
		if($item_consumo->unidade_tipo=="embalagem"){
			$novo_saldo = $item_consumo->qtd_pedida*$item_consumo->fatorconversao2;
		}
		if($item_consumo->unidade_tipo=="uso"){
			$novo_saldo = $item_consumo->qtd_pedida;
		}
		
		//calcula novo saldo e insere na movimentação
		$novo_saldo = $saldo_atual->saldo - $novo_saldo;
		
		mysql_query($t="INSERT INTO estoque_mov SET vkt_id='$vkt_id', produto_id='$item_consumo->produto_id', usuario_id='$usuario_id', almoxarifado_id = '$almoxarifado_id', data_hora = NOW(), saida = $item_consumo->qtd_pedida, saldo='$novo_saldo',
		doc_id='$consumo_id', doc_tipo='consumo'");
		//echo $t." ".mysql_error();
	}
}


function finaliza_pedido($dados){
	global $vkt_id;
	
	mysql_query("UPDATE estoque_consumos SET status='Finalizado' WHERE vkt_id='$vkt_id' AND id='$dados[compra_id]'");
	movimenta_estoque($dados['compra_id'], $dados['estoque_id']);
}


?>