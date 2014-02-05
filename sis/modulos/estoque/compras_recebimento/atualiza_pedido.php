<?
include("../../../_config.php");
include("../../../_functions_base.php");
function atualizaPedido($ocorrencia,$id){
	$query = mysql_query($t="UPDATE estoque_compras SET obs_chegada='$ocorrencia', data_recebimento='".date("Y-m-d")."' WHERE id='".$id."'" );
	//echo mysql_error();
	//echo $t;
}
atualizaPedido($_GET['ocorrencia'],$_GET['compra_id']);
?>