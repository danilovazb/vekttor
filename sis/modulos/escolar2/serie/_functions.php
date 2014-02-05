<?php
$tabela = "escolar2_series";

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
	
	mysql_query($t=" $acao $tabela SET 
	 
	 vkt_id           = '$vkt_id',
	 ensino_id        = '{$_POST['ensino_id']}',
	 nome             = '{$_POST['nome']}',
	 materias_por_dia = '{$_POST['materia_por_dia']}',
	 ordem_ensino     = '{$_POST['ordem_ensino']}'
	 
	 $where ");

	
}


function remover($id) {
	global $tabela,$vkt_id;
	$sql = mysql_query($y=" DELETE FROM $tabela WHERE id = '$id' ");
	//echo $y;
	
}

?>