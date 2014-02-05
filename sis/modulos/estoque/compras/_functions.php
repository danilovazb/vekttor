<?
function cadastraPedido($fornecedor_id,$estoque_id,$vkt_id){
	$data_padrao = mysql_fetch_object(mysql_query("SELECT DATE_ADD(CURDATE(), INTERVAL 2 DAY) as data_padrao"));
	$query = mysql_query($t="INSERT INTO estoque_compras SET vkt_id='$vkt_id',fornecedor_id='".$fornecedor_id."', data_inicio='".date("Y-m-d")."', status='Em aberto', obs_pedido='', obs_chegada='',  unidade_id='$estoque_id', data_chegada_prevista='$data_padrao->data_padrao'");
	//echo $t;
	//echo mysql_error();
	$ultimo_id = mysql_insert_id();
	
	return $ultimo_id;
	//for($i=0;$i<sizeof($dados['produto_id']);$i++){
		//cadastraItem($vkt_id,$dados['produto_id'][$i],$ultimo_id,$dados['qtd'][$i],moedaBrtoUsa($dados['vlr'][$i]),$dados['unidade'][$i],$dados['conversao'][$i],$dados['conversao1']);
	//}
}

function cadastraItem($vkt_id,$dados){
	$query = mysql_query($t="INSERT INTO estoque_compras_item SET vkt_id='$vkt_id', produto_id='".$dados['produto_id']."',pedido_id='".$dados['pedido_id']."',qtd_pedida='".$dados['qtd'].",valor_ini='".$dados['vlr'].",
	unidade='".$dados['unidade']."', fatorconversao='".$dados['conversao1']."', recebido='nao'");
	//echo $t."<br>";
	//echo mysql_error();
}

?>