<?


function verifica_ultima_situacao($atividade_id,$usuario_id){

	$q ="SELECT * FROM projetos_atividades_tempo WHERE atividade_id='$atividade_id' AND fim= '0000-00-00 00:00:00' AND tempo='00:00:00' AND inicio> '1960-01-01 00:00:01' AND usuario_id='$usuario_id'";
	$r = mysql_fetch_object(mysql_query($q));
	return $r;
}

function verifica_ultima_situacao_usuario($usuario_id){

	$q ="SELECT * FROM projetos_atividades_tempo WHERE fim= '0000-00-00 00:00:00' AND tempo='00:00:00' AND inicio> '1960-01-01 00:00:01' AND usuario_id='$usuario_id'";
	//echo $q;
	$r = mysql_fetch_object(mysql_query($q));
	return $r;
}
function retorna_atividade($atividade_id){

	if($atividade_id>0){
		$q ="SELECT * FROM projetos_atividades WHERE id='$atividade_id'";
	
		return $r = mysql_fetch_object(mysql_query($q));
	}
}

function soma_horas_dia($dia,$usuario_id){

	
	$soma_horas_concluidas = @mysql_result(mysql_query($t="SELECT sum(TIME_TO_SEC(`tempo`)) FROM projetos_atividades_tempo WHERE date(fim)='$dia' AND usuario_id='$usuario_id'"),0,0);

	$verifica_se_algum_em_andamento = mysql_fetch_object(mysql_query("SELECT * FROM projetos_atividades WHERE situacao='2' AND funcionario_id='$usuario_id'"));
	$tempo_parcial=0;
	
	if($verifica_se_algum_em_andamento->id>0){
		$ultimo_timer = verifica_ultima_situacao($verifica_se_algum_em_andamento->id,$usuario_id);
		if($ultimo_timer->id>0){
			$segundos_ultimo_timer = mysql_result(mysql_query("select TIME_TO_SEC(TIMEDIFF(now(),'$ultimo_timer->inicio')) "),0,0);
			$soma_de_tempo = $segundos_ultimo_timer;
		}
 	}
	$tempo_parcial = $soma_horas_concluidas+$soma_de_tempo;
	
	$tempo = mysql_result(mysql_query("select TIME_FORMAT(SEC_TO_TIME('$tempo_parcial'),'%H:%i') "),0,0);
	if($tempo != '00:00'){
		return $tempo;	
	}

}
function soma_horas_dia_concluidas($dia,$usuario_id){

	
	$soma_horas_concluidas = @mysql_result(mysql_query($t="SELECT sum(TIME_TO_SEC(`tempo`)) FROM projetos_atividades_tempo WHERE date(fim)='$dia' AND usuario_id='$usuario_id'"),0,0);

	$tempo_parcial = $soma_horas_concluidas+$soma_de_tempo;
	
	$tempo = mysql_result(mysql_query("select TIME_FORMAT(SEC_TO_TIME('$tempo_parcial'),'%H:%i') "),0,0);
	if($tempo != '00:00'){
		return $tempo;	
	}

}
function tempo_atividades_concluidas_saldo($dia,$usuario_id){
	
	$r = mysql_fetch_object(mysql_query("
	SELECT 
		sec_to_time(sum( TIME_TO_SEC( tempo_estimado_horas ))-sum(TIME_TO_SEC( tempo_finalizado_hora ) )) as tempo,
		sum( TIME_TO_SEC( tempo_estimado_horas ))-sum(TIME_TO_SEC( tempo_finalizado_hora ) ) as segundos

	FROM 
		`projetos_atividades`
	WHERE 
		funcionario_id = '$usuario_id'
	AND 
		situacao = '1'
	AND
		date(data_hora_fim) ='$dia' 
	AND 
		tempo_finalizado_hora>'00:00:00'
"));
return array('tempo'=>substr($r->tempo,0,-3),'segundos'=>$r->segundos);
	
}
function tempo_atividades_concluidas($dia,$usuario_id){
	
	$r = mysql_fetch_object(mysql_query("
	SELECT 
		sec_to_time(sum( TIME_TO_SEC( tempo_estimado_horas ))) as tempo,
		sum( TIME_TO_SEC( tempo_estimado_horas )) as segundos

	FROM 
		`projetos_atividades`
	WHERE 
		funcionario_id = '$usuario_id'
	AND 
		situacao = '1'
	AND
		date(data_hora_fim) ='$dia' 
	AND 
		tempo_finalizado_hora>'00:00:00'
"));
return array('tempo'=>substr($r->tempo,0,-3),'segundos'=>$r->segundos);
	
}


function soma_horas_diaAtividade($dia,$usuario_id){

	
	$soma_horas_concluidas = @mysql_result(mysql_query($t="SELECT sum(TIME_TO_SEC(`tempo`)) FROM projetos_atividades_tempo WHERE date(fim)='$dia' AND usuario_id='$usuario_id' "),0,0);
	$verifica_se_algum_em_andamento = mysql_fetch_object(mysql_query("SELECT * FROM projetos_atividades WHERE situacao='2' AND funcionario_id='$usuario_id'"));
	$tempo_parcial=0;
	
	if($verifica_se_algum_em_andamento>id){
		$ultimo_timer = verifica_ultima_situacao($verifica_se_algum_em_andamento->id,$usuario_id);
		if($ultimo_timer->id>0){
			$segundos_ultimo_timer = mysql_result(mysql_query("select TIME_TO_SEC(TIMEDIFF(now(),'$ultimo_timer->inicio')) "),0,0);
			$soma_de_tempo = $segundos_ultimo_timer;
		}
 	}
	$tempo_parcial = $soma_horas_concluidas+$soma_de_tempo;
	return mysql_result(mysql_query("select TIME_FORMAT(SEC_TO_TIME('$tempo_parcial'),'%H:%i') "),0,0);

}

function calcula_tempo_andamento($r,$verifica_se_algum_em_andamento){
	
	
	  $ultimo_timer = $verifica_se_algum_em_andamento;
	  $segundos_atividades = mysql_result(mysql_query("select TIME_TO_SEC('$r->tempo_finalizado_hora')"),0,0);
	  
	  $segundos_ultimo_timer = mysql_result(mysql_query("select TIME_TO_SEC(TIMEDIFF(now(),'$ultimo_timer->inicio')) "),0,0);
	  
	  $soma_de_tempo = $segundos_atividades+$segundos_ultimo_timer;
	  $tempo_parcial = mysql_result(mysql_query("select SEC_TO_TIME('$soma_de_tempo') "),0,0);
	  return $temporel=substr($tempo_parcial,0,5); 

}
?>