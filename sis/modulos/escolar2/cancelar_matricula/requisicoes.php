<?php
include("../../../_config.php");

	$acao = $_POST["acao"];
	
	if($acao == "cancelar_matricula"){
		
		$matricula_id = $_POST["matricula_id"];
		
		mysql_query(" UPDATE escolar2_matriculas SET status = 'cancelada' WHERE id = '$matricula_id' ");
		mysql_query(" UPDATE financeiro_movimento SET status = '2' WHERE doc = '$matricula_id' AND cliente_id = '$vkt_id' ");
		
		echo "sucesso";
		
	}

?>