<?php
	
	function get_nome($nome = NULL, $tamanho = NULL){
	
			if( !empty($nome) and !empty($tamanho) ){
			if( strlen($nome) > $tamanho )
				echo substr($nome,0,$tamanho)."...";
			else
				echo $nome;
			}
			
	}

	function consulta_materia($campos){
		global $vkt_id;
		
		$dados = array();
		
		$result = mysql_fetch_object(mysql_query($pt=" 
		SELECT *, materia.nome AS materia_nome, turma.nome AS turma_nome FROM escolar2_professor_has_turma AS professor_turma 
		  
		  JOIN escolar2_turmas AS turma 
			  ON turma.id = professor_turma.turma_id
		  
		  JOIN escolar2_serie_has_materias AS serie_materia 
			  ON serie_materia.id = professor_turma.serie_has_materia_id
			  
		  JOIN 
			  escolar2_materias AS materia ON materia.id = serie_materia.materia_id
		  
		  WHERE 
			  professor_turma.id = '$campos[professor_as_turma]' 
				
			"));
		
		
		//=================		
		$result2 = mysql_fetch_object(mysql_query("SELECT *, funcionario.nome AS nome_professor FROM escolar2_professor_has_turma AS professor_turma
			JOIN
				escolar2_professores AS professor ON professor.id = professor_turma.professor_id
			JOIN
				rh_funcionario AS funcionario ON funcionario.id = professor.funcionario_id
			WHERE 
				professor_turma.id = '$campos[professor_as_turma]'		
		"));
		
		
		$dados["materia"] = $result->materia_nome;
		$dados["turma"] = $result->turma_nome;
		$dados["professor"] = $result2->nome_professor;
	
		
		return $dados;
		
			
	}
	
	
	function delete_aula($id){

		$sql = mysql_query(" DELETE FROM escolar2_aula WHERE id = '$id' ");	
	}
	
	function insere_aula($campos){	
		
		global $vkt_id;
		
		$acao = "INSERT INTO";
		$where = "";
		
		if (!empty($_POST['id']) ){
			$acao = "UPDATE";
			$where = "WHERE id = '" . mysql_real_escape_string($_POST['id']) . "'";
	
		} 
		
			$sql_insert = " $acao escolar2_aula
								SET
								 vkt_id     = '$vkt_id',
								 periodicidade_id = '$campos[periodo_id]',
								 professor_as_turma_id = '$campos[professor_as_turma_id]',
								 descricao  = '$campos[descricao]',
								 data       = '".dataBrToUsa($campos['data_aula'])."',
								 status     = '1',
								 observacao = '$campos[obs]',
								 texto_aula = '$campos[texto_aula]'
						         $where ";
					
					mysql_query($sql_insert);
					return mysql_insert_id();
					
	}

	function insere_frequencia($dados,$aula){
		global $vkt_id;
			
			//consulta os alunos da turma
			$alunos = mysql_query("SELECT * FROM escolar_matriculas WHERE sala_id='$dados[sala]'");
			
			//insere falta para os alunos
			while($a = mysql_fetch_object($alunos)){
				mysql_query($t="INSERT INTO escolar_frequencia_aula SET 
							aula_id='$aula',
							matricula_aluno_id='$a->aluno_id',
							presenca='0',
							status='1'");
						//echo $t;  
			}
	}
?>