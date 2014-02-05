<?
include("../../../_config.php");
include("../../../_functions_base.php");
function atualizaPedido($ocorrencia_pedido,$ocorrencia_chegada,$id){
	$query = mysql_query($t="UPDATE estoque_vendas SET obs_pedido='$ocorrencia_pedido', obs_chegada = '$ocorrencia_chegada' WHERE id='".$id."'") ;
	//echo mysql_error();
	echo $t;
}
//echo $_GET['ocorrencia'];
atualizaPedido($_GET['ocorrencia_pedido'],$_GET['ocorrencia_chegada'],$_GET['venda_id']);
?>