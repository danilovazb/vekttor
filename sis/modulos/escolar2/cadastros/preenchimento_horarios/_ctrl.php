<?
if($_GET['turma_id']>0){$turma_id=$_GET['turma_id']; }
if($_POST['turma_id']>0){$turma_id=$_POST['turma_id']; }
if($_GET['professor_id']>0){$professor_id=$_GET['professor_id']; }
if($_POST['professor_id']>0){$professor_id=$_POST['professor_id']; }



if($_POST['action']=='Salvar'){
	cadastraHorarios($_POST);
}

if($_POST['action']=="deletar_horario"){
	global $vkt_id;
	$id=$_POST['id'];
	deletarHorario($id);
}


if($turma_id>0){
	$turma=mysql_fetch_object(mysql_query($r="
	SELECT
		et.id         AS turma_id, 
		et.serie_id   AS serie_id, 
		et.unidade_id AS unidade_id, 
		et.horario_id AS horario_id, 
		et.nome       AS turma,
		es.nome       AS serie,
		es.materias_por_dia AS qtd_materias,
		ee.nome  AS ensino, 
		esa.nome AS sala_nome, 
		eh.nome  AS horario	
	FROM 
		escolar2_turmas   AS et, 
		escolar2_series   AS es, 
		escolar2_horarios AS eh, 
		escolar2_salas     AS esa, 
		escolar2_ensino   AS ee
	WHERE 
		et.vkt_id='$vkt_id' 
	AND 
		et.id='$turma_id'
	AND
		es.id = et.serie_id
	AND
		ee.id = es.ensino_id
	AND
		eh.id = et.horario_id
	AND
		esa.id = et.sala_id
	"));
	
	echo mysql_error();
	
	$materias_horarios_q=mysql_query($lululu="
	SELECT 
		eph.id as id,m.nome as materia, rh.nome as professor, 
		eph.dia_semana as dia_semana, eph.tempo as tempo 
	FROM escolar2_professor_has_horario_dia as eph, escolar2_serie_has_materias as esm, escolar2_materias as m, escolar2_professores as ep, rh_funcionario as rh 
	WHERE eph.vkt_id='$vkt_id' AND eph.turma_id='{$turma->turma_id}' AND esm.id = eph.serie_has_materia_id AND m.id = esm.materia_id AND ep.id = eph.professor_id AND rh.id = ep.funcionario_id ");
	echo mysql_error();
	while($m=mysql_fetch_object($materias_horarios_q)){
		$materias_horarios_turma[$m->dia_semana][$m->tempo]=$m->materia . ' - '.$m->professor." <span class='deletar_horario' data-rel='$m->id'>X</span>";
	}
	
}

if($professor_id>0){
	$professor=mysql_fetch_object(mysql_query("SELECT ep.id as id, rh.nome as nome FROM escolar2_professores as ep, rh_funcionario as rh WHERE ep.vkt_id='$vkt_id' AND ep.id='$professor_id' AND rh.id = ep.funcionario_id"));
	$materias_horarios=array();
	
	$materias_horarios_q=mysql_query($lululu="
	SELECT 
	epd.dia_semana as dia_semana, epd.tempo as tempo, et.nome as turma, es.nome as sala,epd.serie_has_materia_id, em.nome AS materia 
	 
	FROM escolar2_professor_has_horario_dia as epd, escolar2_turmas as et, escolar2_salas as es, 
	escolar2_materias as em, 
	escolar2_serie_has_materias AS esm
	
	WHERE epd.vkt_id='$vkt_id' AND (epd.turma_id='{$turma->turma_id}' OR epd.professor_id='{$professor->id}') AND et.id = epd.turma_id AND et.horario_id = '$turma->horario_id'  
	AND es.id = et.sala_id
	
	AND esm.id = epd.serie_has_materia_id
	
	AND em.id = esm.materia_id
	
	");
	while($m=mysql_fetch_object($materias_horarios_q)){
		$materias_horarios_professor[$m->dia_semana][$m->tempo]=$m->turma.' | '.$m->sala;
		//$m->materia
	}
}









