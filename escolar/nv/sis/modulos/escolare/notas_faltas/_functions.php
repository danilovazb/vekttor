<?
function selecionaTodosAlunos($curso,$periodo,$escola,$modulo,$horario){
		global $vkt_id;
		if(!empty($curso)){
			$fim = " AND curso_id = '$curso'";
		}
		if(!empty($periodo)){
			$fim.= " AND periodo_id = '$periodo'";
		}
		if(!empty($escola)){
			$fim.= " AND escola_id = '$escola'";
		}
		if(!empty($modulo)){
			$fim.= " AND modulo_id = '$modulo'";
		}
		if(!empty($horario)){
			$fim.= " AND horario_id = '$horario'";
		}
		$q=mysql_query($t="SELECT * FROM escolar_matriculas
						WHERE vkt_id='$vkt_id'
					 	$fim
					 ");
		
		return $q;
}
function selecionaAluno($al,$curso,$periodo,$escola,$modulo,$horario){
		global $vkt_id;
		if(!empty($curso)){
			$fim = "AND em.curso_id = '$curso'";
		}
		if(!empty($periodo)){
			$fim.= "AND em.periodo_id = '$periodo'";
		}
		if(!empty($escola)){
			$fim.= "AND em.escola_id = '$escola'";
		}
		if(!empty($modulo)){
			$fim.= "AND em.modulo_id = '$modulo'";
		}
		if(!empty($horario)){
			$fim.= "AND em.horario_id = '$horario'";
		}
		$aluno = mysql_fetch_object(mysql_query($t="SELECT *,ee.nome as escola,
			  ep.nome as periodo,
			  ea.nome as aluno,
			  emodulo.nome as modulo,
			  es.nome as sala,
			  eh.nome as horario,
			  em.id as idmatricula,
			  ea.id as idaluno	 
			  FROM escolar_matriculas em
			  INNER JOIN escolar_escolas ee ON em.escola_id=ee.id
			  INNER JOIN escolar_periodos ep ON em.periodo_id=ep.id
			  INNER JOIN escolar_alunos ea ON em.aluno_id=ea.id
			  INNER JOIN escolar_modulos emodulo ON em.modulo_id=emodulo.id
			  INNER JOIN escolar_salas es ON em.sala_id=es.id
			  INNER JOIN escolar_horarios eh ON em.horario_id=eh.id
			  WHERE em.aluno_id=$al
			  $fim
			  AND em.vkt_id='$vkt_id'"
			 ));
			 
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
?>  