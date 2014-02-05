<?php
include("../../../_config.php");
include("../../../_functions_base.php");

	$id=$_GET['id'];
	$qtd_item=$_GET['qtd_item'];
	$acao=$_GET['acao'];
	if($acao==0){
		$sql="DELETE FROM aluguel_equipamentos_itens WHERE id='$id' AND vkt_id='$vkt_id'";
	}
	if($acao==1){
		$sql="DELETE FROM aluguel_equipamentos_itens WHERE equipamento_id='$id' AND status='1' AND vkt_id='$vkt_id'";
	}
	//alert($sql);
	mysql_query($sql);	
?>