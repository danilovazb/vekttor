<?


function tarefasAtrazadas(){
	global $usuario_id;
	$numero =  mysql_result(mysql_query($t="SELECT  count(*) FROM projetos_atividades WHERE funcionario_id='$usuario_id' AND data_limite <> '0000-00-00' AND data_limite > NOW()"),0,0);
	//echo $t;
	return $numero;
	
	
}

function tarefasTempoExedido(){
	global $usuario_id;
	$numero =  mysql_result(mysql_query($t="SELECT  count(*) FROM projetos_atividades WHERE funcionario_id='$usuario_id' AND tempo_estimado_horas<tempo_finalizado_hora AND situacao in('0','2','3')"),0,0);
	//echo $t;
	return $numero;
	
	
}
function tarefasASeremAprovadas(){
	global $usuario_id;
	$numero =  mysql_result(mysql_query($t="SELECT  count(*) FROM projetos_atividades WHERE funcionario_id='$usuario_id' AND aprovado_pelo_responsavel='0' AND situacao='1'"),0,0);
	//echo $t;
	return $numero;
	
	
}


function starta($atividade_id){
	global $usuario_id;
	$ultima = verifica_ultima_situacao($atividade_id);
		if($ultima->id<1){
			mysql_query("INSERT INTO projetos_atividades_tempo SET usuario_id='$usuario_id',atividade_id='$atividade_id', inicio = now() ");
			mysql_query("UPDATE projetos_atividades SET	situacao= '2' WHERE id='$atividade_id' AND funcionario_id='$usuario_id'");
	
		}
	
}
function pausa($atividade_id){
	global $usuario_id;
	$ultima = verifica_ultima_situacao($atividade_id);
	if($ultima->id>0){
		mysql_query($t="UPDATE projetos_atividades_tempo SET fim = now(), tempo=TIMEDIFF(now(),'$ultima->inicio') WHERE id='$ultima->id'  AND usuario_id='$usuario_id' AND atividade_id='$atividade_id'");
		$soma_horas = @mysql_result(mysql_query($t="SELECT SEC_TO_TIME(sum(TIME_TO_SEC(`tempo`))) FROM projetos_atividades_tempo WHERE atividade_id='$atividade_id' AND usuario_id='$usuario_id'"),0,0);
		mysql_query($t="UPDATE projetos_atividades SET	situacao= '0',tempo_finalizado_hora='$soma_horas' WHERE id='$atividade_id' AND funcionario_id='$usuario_id'");
	}
}
function conclui_atividade($atividade_id){
	global $usuario_id;
	pausa($atividade_id);
	
	$i = mysql_fetch_object(mysql_query("SELECT * FROM projetos_atividades WHERE id='$atividade_id' "));
	
	if($usuario_id==$i->usuario_id_cadastrou){
		$sql_add= ",aprovado_pelo_responsavel='1'";
	}

	mysql_query($t="UPDATE projetos_atividades SET	situacao= '1',data_hora_fim=now()$sql_add WHERE id='$atividade_id' AND funcionario_id='$usuario_id'");
	

}
function ativa_atividade($atividade_id){
	global $usuario_id;

	mysql_query($t="UPDATE projetos_atividades SET	situacao= '0',data_hora_fim='' WHERE id='$atividade_id' AND funcionario_id='$usuario_id'");

}

function verifica_ultima_situacao($atividade_id){
	global $usuario_id;
	$q ="SELECT * FROM projetos_atividades_tempo WHERE atividade_id='$atividade_id' AND fim= '0000-00-00 00:00:00' AND tempo='00:00:00' AND inicio> '1960-01-01 00:00:01' AND usuario_id='$usuario_id'";
	$r = mysql_fetch_object(mysql_query($q));
	return $r;
}

function soma_horas_dia($dia){
	global $usuario_id;
	
	$soma_horas_concluidas = @mysql_result(mysql_query($t="SELECT sum(TIME_TO_SEC(`tempo`)) FROM projetos_atividades_tempo WHERE date(fim)='$dia' AND usuario_id='$usuario_id'"),0,0);

	$verifica_se_algum_em_andamento = mysql_fetch_object(mysql_query("SELECT * FROM projetos_atividades WHERE situacao='2' AND funcionario_id='$usuario_id'"));
	$tempo_parcial=0;
	
	if($verifica_se_algum_em_andamento>id){
		$ultimo_timer = verifica_ultima_situacao($verifica_se_algum_em_andamento->id);
		if($ultimo_timer->id>0){
			$segundos_ultimo_timer = mysql_result(mysql_query("select TIME_TO_SEC(TIMEDIFF(now(),'$ultimo_timer->inicio')) "),0,0);
			$soma_de_tempo = $segundos_ultimo_timer;
		}
 	}
	$tempo_parcial = $soma_horas_concluidas+$soma_de_tempo;
	return mysql_result(mysql_query("select TIME_FORMAT(SEC_TO_TIME('$tempo_parcial'),'%H:%i') "),0,0);

}
function soma_horas_diaAtividade($dia,$atividade_id){
	global $usuario_id;
	
	$soma_horas_concluidas = @mysql_result(mysql_query($t="SELECT sum(TIME_TO_SEC(`tempo`)) FROM projetos_atividades_tempo WHERE date(fim)='$dia' AND usuario_id='$usuario_id' AND atividade_id='$atividade_id'"),0,0);

	$verifica_se_algum_em_andamento = mysql_fetch_object(mysql_query("SELECT * FROM projetos_atividades WHERE situacao='2' AND funcionario_id='$usuario_id'"));
	$tempo_parcial=0;
	
	if($verifica_se_algum_em_andamento>id){
		$ultimo_timer = verifica_ultima_situacao($verifica_se_algum_em_andamento->id);
		if($ultimo_timer->id>0){
			$segundos_ultimo_timer = mysql_result(mysql_query("select TIME_TO_SEC(TIMEDIFF(now(),'$ultimo_timer->inicio')) "),0,0);
			$soma_de_tempo = $segundos_ultimo_timer;
		}
 	}
	$tempo_parcial = $soma_horas_concluidas+$soma_de_tempo;
	return mysql_result(mysql_query("select TIME_FORMAT(SEC_TO_TIME('$tempo_parcial'),'%H:%i') "),0,0);

}

function editaexecutor($d){
	global $usuario_id;
	
	if($d[aguardando_resposta]==1){
		$addedit =  ",situacao='3'"	;
	}
	
		mysql_query($t="UPDATE projetos_atividades SET	comentario_executor='$d[comentario_executor]'$addedit WHERE id='$d[id]' AND funcionario_id='$usuario_id'");
		echo $t;
		exit();
}

?>