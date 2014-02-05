<?php
/*
	// configuraçao inicial do sistema
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");

	$movimentacao = mysql_query("SELECT * FROM estoque_mov WHERE doc_id='252' AND doc_tipo = 'transferencia'");
	echo mysql_error();
	while($m = mysql_fetch_object($movimentacao)){
	
		$saldo = mysql_fetch_object(mysql_query("SELECT * FROM estoque_mov WHERE produto_id='$m->produto_id' AND almoxarifado_id='1' AND doc_tipo!='transferencia' ORDER BY id DESC LIMIT 1"));
		echo $saldo->saldo."<br>";
		
		$novo_saldo = $saldo->saldo - $m->entrada;
		mysql_query($t="INSERT INTO estoque_mov SET produto_id = '$m->produto_id', usuario_id='45', almoxarifado_id = '1', data_hora = '2013-04-04 16:50:43', entrada='0', saida='$m->entrada',saldo='$novo_saldo', vkt_id='14', doc_id='252', doc_tipo='transferencia'");
		
		echo mysql_error()." ".$t."<br>";
	}
	*/
?>