<?php



	function retorna_horarios($professor_id=NULL, $serie_has_materia = NULL,$professor_turma_clicado = NULL){
		global $vkt_id;
		
		$sql = mysql_query($ts=" 
		SELECT
		    horario.id   AS id,
			horario.nome AS nome_horario
		FROM 
			escolar2_professor_has_turma AS professor_turma
		
		JOIN escolar2_turmas AS turma 
			ON turma.id = professor_turma.turma_id	
			
		
		JOIN escolar2_horarios AS horario
			ON horario.id = turma.horario_id		
		
		WHERE 
			professor_turma.vkt_id = '$vkt_id' 
		AND 
			professor_turma.professor_id = '$professor_id' 
		AND
			professor_turma.serie_has_materia_id = '$serie_has_materia'
		AND
			professor_turma.id != '$professor_turma_clicado'
				
		
		GROUP BY turma.horario_id	
			
			");
		
		while($registros = mysql_fetch_array($sql)){
			$dados[] = $registros;
		}
		return $dados;	
	}
	
	function retorna_turma_horario($horario_id = NULL,$serie_has_materia_id = NULL,$professor_id=NULL){
		global $vkt_id;
		$sql = mysql_query($s="
		
		SELECT  
			
			turma.nome AS nome_turma,
			professor_turma.id AS professor_has_turma_id 
		
		FROM escolar2_turmas AS turma
		
			JOIN escolar2_professor_has_turma AS professor_turma
				ON professor_turma.turma_id = turma.id
				
			WHERE
				turma.vkt_id = '$vkt_id'	
			
			AND
				turma.horario_id = '$horario_id'
				
			AND
				professor_turma.serie_has_materia_id = '$serie_has_materia_id'	
			
			AND
				professor_turma.professor_id = '$professor_id'	 
		
		");
		
		
		while($registros = mysql_fetch_array($sql)){
			$dados[] = $registros;
		}
		return $dados;
	}
	
	function nome_materia($serie_has_materia_id){
		global $vkt_id;
		
		$sql =  mysql_fetch_object( mysql_query("
			SELECT materia.nome AS nome_materia FROM escolar2_serie_has_materias AS serie_materia
			
				JOIN escolar2_materias AS materia
					ON materia.id = serie_materia.materia_id
					
			WHERE
				serie_materia.vkt_id = '$vkt_id'
			AND
				serie_materia.id = '$serie_has_materia_id'	
		"));
		
		return $sql->nome_materia;
	}
	
	function professor_turma_id($professor_id,$turma_id,$serie_has_materia){
		global $vkt_id;
		$sql = ( mysql_query(" 
			SELECT 
				professor_turma.id AS professor_has_turma_id,
				turma.unidade_id   AS unidade_id
			FROM 
				escolar2_professor_has_turma AS professor_turma
			
			JOIN escolar2_turmas AS turma
				ON turma.id = professor_turma.turma_id
			
			
			WHERE 
				professor_turma.vkt_id = '$vkt_id'
			AND
				professor_turma.professor_id = '$professor_id'
			AND
				professor_turma.turma_id = '$turma_id'
			AND
				professor_turma.serie_has_materia_id = '$serie_has_materia'
		"));
		
		
		while($registros = mysql_fetch_array($sql)){
			$dados["unidade_id"] = $registros["unidade_id"];
			$dados["professor_has_turma_id"] = $registros["professor_has_turma_id"];
		}
		
		return $dados;
	}
	
	/* Inserçao */
	
	function insere_aula($campos){
		global $vkt_id;
		
		$outras_turmas = $campos["outras_turmas"];
		
		if( count($outras_turmas) > 0){
			cadastra_outras_aulas($campos);
		}
		
		$sql_insert = " INSERT INTO escolar2_aula SET
		
		   vkt_id                = '$vkt_id',
		   periodicidade_id      = '$campos[periodo_id]',
		   professor_as_turma_id = '$campos[professor_as_turma_id]',
		   descricao  = '$campos[descricao]',
		   data       = '".dataBrToUsa($campos['data_aula'])."',
		   status     = '1',
		   observacao = '$campos[obs]',
		   texto_aula = '$campos[texto_aula]' ";
					
		mysql_query($sql_insert);
		
	}
	
	function cadastra_outras_aulas($campos){
		global $vkt_id;
		
		$outras_turmas = $campos["outras_turmas"];
		
			for($i=0 ; $i < count($outras_turmas); $i++){
			  $sql_insert = " INSERT INTO escolar2_aula SET
				 vkt_id                = '$vkt_id',
				 periodicidade_id      = '$campos[periodo_id]',
				 professor_as_turma_id = '$outras_turmas[$i]',
				 descricao  = '$campos[descricao]',
				 data       = '".dataBrToUsa($campos['data_aula'])."',
				 status     = '1',
				 observacao = '$campos[obs]',
				 texto_aula = '$campos[texto_aula]' ";
				 mysql_query($sql_insert);
		   
			}
		
	}

?>