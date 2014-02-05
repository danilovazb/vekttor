<?php
$tabela = "escolar2_materias";

function cadastra () {
		
		
	global $tabela,$vkt_id;
	
	$acao = "";
	$where = "";
	
	if (!empty($_POST['id']) ){   
		$acao = "UPDATE";
		$where = "WHERE id = '" . mysql_real_escape_string($_POST['id']) . "' AND vkt_id='$vkt_id'";
	} else {
		$acao = "INSERT INTO";	
	}
	
	mysql_query($t=" $acao $tabela SET vkt_id = '$vkt_id', nome   = '{$_POST['nome']}' $where ");

	
}


function remover($id) {
	global $tabela,$vkt_id;
	$sql = mysql_query($y=" DELETE FROM $tabela WHERE id = '$id' ");
	//echo $y;
	
}

?>