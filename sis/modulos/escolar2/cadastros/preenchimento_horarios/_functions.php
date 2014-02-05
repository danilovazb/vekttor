<?

function cadastraHorarios($dados){
	global $vkt_id;
	$tem_turma=mysql_result(mysql_query($a="SELECT COUNT(*) FROM escolar2_professor_has_turma WHERE vkt_id='$vkt_id' AND professor_id='{$dados['professor_id']}' AND turma_id='{$dados['turma_id']}' AND serie_has_materia_id='{$dados['serie_has_materia_id']}' "),0);
	if( $tem_turma==0 ){
		mysql_query("INSERT INTO escolar2_professor_has_turma SET vkt_id='$vkt_id', professor_id='{$dados['professor_id']}', turma_id='{$dados['turma_id']}', serie_has_materia_id='{$dados['serie_has_materia_id']}' ");
	}
	if(count($dados['horario_dia'])>0){
		foreach($dados['horario_dia'] as $h){
			$h=explode('_',$h);
			$tempo=$h[0];
			$dia=$h[1];
			mysql_query("INSERT INTO escolar2_professor_has_horario_dia 
			SET vkt_id='$vkt_id', professor_id='{$dados['professor_id']}', turma_id='{$dados['turma_id']}', horario_id='{$dados['horario_id']}', serie_has_materia_id='{$dados['serie_has_materia_id']}', tempo='$tempo', dia_semana='$dia' ");		
		}
	}
}

function deletarHorario($id){
	global $vkt_id;
	
	$horario_dia=mysql_fetch_object(mysql_query("SELECT * FROM escolar2_professor_has_horario_dia WHERE vkt_id='$vkt_id' AND id='$id'"));
	
	$professor_id=$horario_dia->professor_id;
	$turma_id=$horario_dia->turma_id;
	
	$verifica_turma = mysql_fetch_object(mysql_query("SELECT COUNT(*) AS qtd FROM escolar2_professor_has_horario_dia WHERE vkt_id='$vkt_id' AND serie_has_materia_id='$horario_dia->serie_has_materia_id'"));
	
	
	if($verifica_turma->qtd == 1){
		mysql_query( $del="DELETE FROM escolar2_professor_has_turma WHERE vkt_id='$vkt_id' AND serie_has_materia_id = '$horario_dia->serie_has_materia_id' ");
	}
	mysql_query("DELETE FROM escolar2_professor_has_horario_dia WHERE vkt_id='$vkt_id' AND id='$horario_dia->id' ");
	
}