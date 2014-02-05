<?php

$tabela = "escolar_escolas";

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
	vkt_id='$vkt_id',
	 nome 			= '{$_POST['nome']}',
	 endereco 		= '{$_POST['endereco']}', 
	 bairro 		= '{$_POST['bairro']}', 
	 telefone 		= '{$_POST['telefone']}', 
	 email 			= '{$_POST['email']}',
	 media          = '{$_POST['media']}', 
	 banco 			= '{$_POST['banco']}', 
	 agencia 		= '{$_POST['agencia']}', 
	 conta 			= '{$_POST['conta']}', 
	 tipo_boleto 	= '{$_POST['tipo_boleto']}',
	 conta_cedente 	= '{$_POST['conta_cedente']}',
	 conta_cedente_dv 	= '{$_POST['conta_cedente_dv']}',
	 convenio 	= '{$_POST['convenio']}',
	 contrato 	= '{$_POST['contrato']}',
	 carteira 	= '{$_POST['carteira']}',
	 termos		= '{$_POST['termos']}'
 
	 $where");
	
}

function remover () {
	global $tabela,$vkt_id;
	$q = mysql_query ($trace = "DELETE FROM $tabela WHERE id = '" . mysql_real_escape_string($_POST['id']) . "' AND vkt_id='$vkt_id'");	
}

?>