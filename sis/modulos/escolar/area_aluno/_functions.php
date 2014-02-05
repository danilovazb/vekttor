<?php

function selecionaAluno($al,$matricula){
		global $vkt_id;
		
		if(!empty($matricula)){
			$fim = " AND em.id = '$matricula'";
		}else{
			$fim = "ORDER BY em.id DESC";	
		}

		$aluno = mysql_query($t="SELECT *,ee.nome as escola,
			  ep.nome as periodo,
			  ea.nome as aluno,
			  emodulo.nome as modulo,
			  es.nome as sala,
			  eh.nome as horario,
			  em.id as idmatricula,
			  ea.id as idaluno,
			  ec.nome as curso
			  FROM escolar_matriculas em
			  INNER JOIN escolar_escolas ee ON em.escola_id=ee.id
			  INNER JOIN escolar_periodos ep ON em.periodo_id=ep.id
			  INNER JOIN escolar_alunos ea ON em.aluno_id=ea.id
			  INNER JOIN escolar_modulos emodulo ON em.modulo_id=emodulo.id
			  INNER JOIN escolar_salas es ON em.sala_id=es.id
			  INNER JOIN escolar_horarios eh ON em.horario_id=eh.id
			  INNER JOIN escolar_cursos ec ON em.curso_id=ec.id
			  WHERE em.aluno_id=$al
			   AND em.vkt_id='$vkt_id'
			   $fim"			   
			 );
			 
			 return $aluno;
}

function selecionaNota($aluno){
	global $vkt_id;
	$notas = mysql_query($t="SELECT * FROM escolar_notas en
							INNER JOIN escolar_avaliacao ea on en.avaliacao_id = ea.id
							INNER JOIN escolar_periodicidade_avaliacao epa ON ea.periodicidade_id = epa.id
							WHERE en.matricula_aluno_id=$aluno
							AND en.vkt_id='$vkt_id'
							ORDER BY epa.id
				  ");
				  
	return $notas;
}

function selecionaMatriculas($al){
		global $vkt_id;
		
		$fim = "ORDER BY em.id DESC";	
		
		$matricula = mysql_query($t="SELECT *,ee.nome as escola,
			  ep.nome as periodo,
			  ea.nome as aluno,
			  emodulo.nome as modulo,
			  es.nome as sala,
			  eh.nome as horario,
			  em.id as idmatricula,
			  ea.id as idaluno,
			  ec.nome as curso
			  FROM escolar_matriculas em
			  INNER JOIN escolar_escolas ee ON em.escola_id=ee.id
			  INNER JOIN escolar_periodos ep ON em.periodo_id=ep.id
			  INNER JOIN escolar_alunos ea ON em.aluno_id=ea.id
			  INNER JOIN escolar_modulos emodulo ON em.modulo_id=emodulo.id
			  INNER JOIN escolar_salas es ON em.sala_id=es.id
			  INNER JOIN escolar_horarios eh ON em.horario_id=eh.id
			  INNER JOIN escolar_cursos ec ON em.curso_id=ec.id
			  WHERE em.aluno_id=$al
			   AND em.vkt_id='$vkt_id'
			   $fim"			   
			 );
			 //echo $t;
			 return $matricula;
}
?>