<?
include("../../../_config.php");
include("../../../_functions_base.php");
function atualizaPedido($ocorrencia,$id,$unidade_id){
	$query = mysql_query($t="UPDATE estoque_compras SET obs_pedido='$ocorrencia' WHERE id='$id'" );
	//echo mysql_error();
	//echo $t;
}
atualizaPedido($_GET['ocorrencia'],$_GET['compra_id'],$_GET['estoque_id']);
?>