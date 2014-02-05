<?php
$tabela = "escolar2_series";

	  /* Funçoes Boletim  */  
  function retorna_periodo_avaliacao($unidade_id = NULL){
	  global $vkt_id;
	  
	  if( !empty($unidade_id) ){
	  
		$sql_periodo_avaliacao = mysql_query($t=" 
		SELECT ab.id AS id, pa.nome AS nome, pa.id AS periodo_av 
		
		 FROM escolar2_periodos_avaliacao AS pa 
		 JOIN escolar2_avaliacao_bimestre AS ab ON ab.bimestre_id = pa.id
		
		  WHERE pa.vkt_id = '$vkt_id' AND pa.unidade_id = '$unidade_id' GROUP BY ab.bimestre_id ORDER BY pa.id ASC ");
		  
		  while($periodo_avaliacao = mysql_fetch_array($sql_periodo_avaliacao)){
				  $dados[] = $periodo_avaliacao;
		  }
	  }
	  
	  if( count($dados) > 0 )
		  return $dados;
  }
  
  function retorna_media_aluno($professor_as_turma_id = NULL, $aluno_matricula_id = NULL,$periodo_avaliacao_id = NULL, $materia_id = NULL){
	  
	  global $vkt_id;
	  
	  	$info_nota = mysql_fetch_object(mysql_query($sql=" 
		SELECT SUM(nota.nota) AS soma_nota,COUNT(*) AS qtd	  						
		 
		 FROM escolar2_avaliacao_bimestre AS avb
		 
		 JOIN escolar2_avaliacao AS av ON av.avaliacao_bimestre_id = avb.id
		 JOIN escolar2_aluno_as_avaliacao AS nota ON nota.avaliacao_id = av.id
		 
		 JOIN escolar2_professor_has_turma AS pt ON pt.id = av.professor_as_turma_id 
		 JOIN escolar2_serie_has_materias AS sm ON sm.id = pt.serie_has_materia_id
		 	
		  WHERE avb.vkt_id = '$vkt_id'
		  AND avb.bimestre_id = '$periodo_avaliacao_id'	
		  AND sm.materia_id = '$materia_id' "));
			
		if( !empty($info_nota->qtd) )	
			return number_format($info_nota->soma_nota/$info_nota->qtd,1,".",",");
			
		
  } 
  
  function retorna_faltas_presenca_aluno($professor_as_turma_id = NULL, $aluno_matricula_id = NULL,$periodo_aula_id = NULL, $tipo = 2){
	  global $vkt_id;
	  
	  $filtro = 2;
	  
	if( $tipo == "presenca" )
		  $filtro = 1;
		  
	  $info_faltas = mysql_fetch_object(mysql_query($sql=" 	
	  SELECT  COUNT(*) AS numero_faltas
	  
	   FROM escolar2_aula AS aula 
		  
	    JOIN escolar2_frequencia_aula AS frequencia ON frequencia.aula_id = aula.id
			  
		WHERE aula.vkt_id = '$vkt_id'	  
		  AND aula.professor_as_turma_id = '$professor_as_turma_id'
		  AND aula.periodicidade_id = '$periodo_aula_id'
		  AND frequencia.matricula_aluno_id = '$aluno_matricula_id'
		  AND frequencia.presenca = '$filtro' "));
				  
	  if( !empty($info_faltas->numero_faltas) )
		  return $info_faltas->numero_faltas;
	  else 
		  return 0;
	  	
  }
  
  function retorna_qtd_aula_periodo($professor_as_turma_id = NULL,$periodo_id = NULL){
	  
	  global $vkt_id;
	  
	  $info_aula =  mysql_fetch_object(mysql_query(" 
	  		SELECT COUNT(*) AS qtd_aula FROM escolar2_aula 
				
			 WHERE vkt_id = '$vkt_id' 
			  AND periodicidade_id = '$periodo_id'  
			  AND professor_as_turma_id = '$professor_as_turma_id'	
			
			"));
	 	return $info_aula->qtd_aula;
  }
  
  function retorna_serie_materia($serie_id = NULL, $turma_id = NULL){
	  	
		$sql_materia = mysql_query($ty=" 
		SELECT materia.nome AS nome_materia, 
		  materia.id AS materia_id, 
		  serie_materia.serie_id AS serie_id, 
		  turma.id AS turma_id, 
		  pt.id AS professor_has_turma   
					  
		  FROM escolar2_serie_has_materias AS serie_materia		
		  	
			JOIN escolar2_materias AS materia ON materia.id = serie_materia.materia_id
				
			JOIN escolar2_turmas AS turma ON turma.serie_id = serie_materia.serie_id
				
			JOIN escolar2_professor_has_turma AS pt ON pt.turma_id = turma.id
			
			AND serie_materia.serie_id = '$serie_id'
			
			AND turma.id = '$turma_id'
				
			GROUP BY materia_id
		   ");
		  
		   while($materia = mysql_fetch_array($sql_materia)){
			   $dados[] = $materia;
			}
			
			
			if( count($dados) > 0 )
			return $dados;
			
  }
  
  function calculo_porcentagem_faltas($numero_faltas = NULL, $numero_aulas = NULL){
	  
	  if( !empty($numero_faltas) )
	  	$porcent_falta = ((100 * $numero_faltas) / $numero_aulas); 
	  
	  return $porcent_falta;
  }
  
  function formula_unidade($unidade_id = NULL){
	   global $vkt_id;
	   
	   $sql =  mysql_fetch_object( mysql_query(" SELECT escolar2_unidades.formula_media AS formula FROM escolar2_unidades WHERE vkt_id = '$vkt_id' AND id = '$unidade_id' "));
	   
	   return $sql->formula;
	   
  }
  
  /*
  	Fim Funçoes Boletim  
  */
	
	
	function get_nome($nome = NULL, $tamanho = NULL){
	
			if( !empty($nome) and !empty($tamanho) ){
			if( strlen($nome) > $tamanho )
				echo substr($nome,0,$tamanho)."...";
			else
				echo $nome;
			}
			
	}


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