<?
function adicionaNegociacaoCliente($negociacao_id, $cliente_id){
	$adiciona_q = mysql_query($x="INSERT INTO negociacao_cliente SET negociacao_id='$negociacao_id', cliente_id='$cliente_id' ");
}

?>