<?
include("../../../_config.php");
include("../../../_functions_base.php");
include('_functions.php');

	$query=mysql_query($t="UPDATE estoque_compras_item SET vkt_id='$vkt_id', produto_id='".$_GET['produto_id']."', qtd_enviada='".$_GET['qtd']."', valor_fim='".$_GET['valor']."', ocorrencia='".$_GET['ocorrencia']."' WHERE id='".$_GET['item_id']."'");
	echo $t."<br>";
	$query=mysql_query($t="UPDATE estoque_compras SET obs_chegada='".$_GET['obs']."', nro_nota_fiscal='".$_GET['nota_fiscal']."' WHERE id='".$_GET['pedido_id']."'");
	//echo $t."<br>";	
	
?>