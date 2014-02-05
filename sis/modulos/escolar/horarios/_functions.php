<?php

$tabela = "escolar_horarios";

// Controlador

function cadastra () {
	
	global $tabela,$vkt_id;
	
	$acao = "";
	$where = "";
	
	if( $_POST['horario_id']>0 ){
		$acao = "UPDATE";
		$where = "WHERE id = '" . mysql_real_escape_string($_POST['horario_id']) . "' AND vkt_id='$vkt_id'";
	} else {
		$acao = "INSERT INTO";	
	}
	
	$semana= implode(',',$_POST['semana']);
	
	$escolas_total = count($_POST['modulo_id']);
	
	for($i=0; $i<$escolas_total; $i++ ) {
		$infosp= explode(",",$_POST['modulo_id'][$i]);
		$modulo_id=$infosp[0];
		$curso_id=$infosp[1];
		$escola_id=$infosp[2];
		mysql_query ("$acao $tabela SET 
		vkt_id						= '$vkt_id',
		 escola_id 					= '$escola_id',
		 modulo_id 					= '$modulo_id',
		 curso_id 					= '$curso_id',
		 periodo_id 				= '{$_POST['periodo_id']}',
		 nome						=  '{$_POST['nome']}', 
		 data_aulas_inicio			= '".dataBrToUsa($_POST['data_aulas_inicio'])."',
		 data_aulas_fim				= '".dataBrToUsa($_POST['data_aulas_fim'])."',
		 dias_semana				= '$semana',
		 horario_inicio				= '{$_POST['horario_inicio']}:00',
		 horario_fim				= '{$_POST['horario_fim']}:00',
		 vagas_por_sala				= '{$_POST['vagas_por_sala']}',
		 qtde_salas					= '{$_POST['qtde_salas']}',
		 valor 						= '{$_POST['valor']}',
		 valor_bolsista				= '{$_POST['valor_bolsista']}',
		 vagas_por_sala_rematricula	= '{$_POST['vagas_por_sala_rematricula']}',
		 vagas_total_horario		= '{$_POST['vagas_total_horario']}'
			 
		 $where")or die(mysql_error());
		 
	}
	
}

function remover () {
	global $tabela;
	
	$q = mysql_query ($t="DELETE FROM $tabela WHERE id = '" . mysql_real_escape_string($_POST['horario_id']) . "'");	
	//echo mysql_error().$t;
}

function converte_numeros_comvirgula_em_dias_semanas($dias,$semana_abreviado){
	
	$dias = explode(',',$dias );
	
	for($i=0;$i<count($dias);$i++){
		$dias_semana[] = $semana_abreviado[$dias[$i]];	
	}
	return implode(', ',$dias_semana);
}

?>