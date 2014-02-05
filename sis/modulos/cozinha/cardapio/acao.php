<?php
	// configuraчуo inicial do sistema
	include("../../../_config.php");
	// funчѕes base do sistema
	include("../../../_functions_base.php");
	
	global $vkt_id;
	$contrato_id = $_GET['contrato_id'];
	$data_cardapio = $_GET['data'];
	
	if($_GET['action']=='limpardia'){
		mysql_query($t="DELETE FROM cozinha_cardapio_dia_refeicao WHERE contrato_id='$contrato_id' AND data='$data_cardapio' AND vkt_id='$vkt_id'");
		echo $t;
		exit();
	}
?>