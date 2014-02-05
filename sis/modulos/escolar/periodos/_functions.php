<?php

$tabela = "escolar_periodos";

// Controlador

function cadastra () {
	
	global $tabela,$vkt_id;
	
	$acao = "";
	$where = "";
	
	if ( isset($_POST['id']) && !empty($_POST['id']) ){
		$acao = "UPDATE";
		$where = "WHERE id = '" . mysql_real_escape_string($_POST['id']) . "' AND vkt_id='$vkt_id'";
	} else {
		$acao = "INSERT INTO";	
	}
	
	mysql_query ("$acao $tabela SET 
	vkt_id 			= '$vkt_id',
	 nome 			= '{$_POST['nome']}',
	 inicio_aulas 	= '".dataBrToUsa($_POST['inicio_aulas'])."', 
	 fim_aulas 		= '".dataBrToUsa($_POST['fim_aulas'])."', 
	 inicio_matricula	= '".dataBrToUsa($_POST['inicio_matricula'])."', 
	 fim_matricula 		= '".dataBrToUsa($_POST['fim_matricula'])."', 
	 inicio_rematricula	= '".dataBrToUsa($_POST['inicio_rematricula'])."', 
	 fim_rematricula 	= '".dataBrToUsa($_POST['fim_rematricula'])."', 
	 obs 				= '{$_POST['obs']}'
	 
	 $where");
	
}

function remover () {
	global $tabela,$vkt_id;
	$q = mysql_query ($trace = "DELETE FROM $tabela WHERE id = '" . mysql_real_escape_string($_POST['id']) . "' AND vkt_id='$vkt_id'");	
}

?>