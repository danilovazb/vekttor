<?php

	if($_POST['action'] == 'Salvar'){
		insere_aula($_POST);
	 }
	 if($_POST['action'] == 'Excluir'){
		delete_aula($_POST["id"]);
	 }
	
	 
/*------------------------------ RECEBE VALORES ----------------------------------*/
	 if($_GET["id"] > 0 and $_GET["unidade_id"]){
		 $_GET["unidade_id"] = $_GET["unidade_id"];
		 $_GET["professor_as_turma"] = $_GET["professor"];
		 
		 $id = $_GET['id'];
		 $r = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_aula WHERE id = '$id' "));
	 } 
	 
	 if($_GET['aula_id'] > 0){
		
		$aula_id = $_GET['aula_id'];
		
		$aula = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar2_aula AS aula 
		JOIN 
			escolar2_professor_has_turma AS professor_turma ON aula.professor_as_turma_id = professor_turma.id
		WHERE
			aula.id = '$aula_id' "));
			
		
		// consulta na tabela matricula para pegar todos os alunos da turma
		$sql_turma = mysql_query($y=" SELECT * FROM escolar2_matriculas WHERE turma_id = '$aula->turma_id' AND matricula_rematricula = 'matricula' AND status != 'cancelada' ");
			
		
		/*=== SÉRIE MATÉRIA ===*/	
		
		$sql_serie_materia = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_serie_has_materias AS serie_materia
		JOIN
			escolar2_materias AS materia ON materia.id = serie_materia.materia_id 
		WHERE 
			serie_materia.id = '$aula->serie_has_materia_id' ")); 
			
		
		$sql_turma_chamada = mysql_query(" SELECT * FROM escolar2_matriculas WHERE turma_id = '$aula->turma_id' AND status = 'matricula' ");
		
		
		/*=== FREQUENCIA ===*/
		
		$sql_frequencia = mysql_query(" SELECT * FROM escolar2_frequencia_aula WHERE aula_id = '$aula_id' ");
		
		
		
		if(mysql_num_rows($sql_frequencia) == 0){
			
			while($aula_turma = mysql_fetch_object($sql_turma_chamada)){
				
				$aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_alunos WHERE id = '$aula_turma->aluno_id'"));
					
					mysql_query(" INSERT INTO escolar2_frequencia_aula SET 
					aula_id = '$aula_id',
					matricula_aluno_id = '$aula_turma->id',
					presenca = '2',
					status   = '0'
					");
					
			}
			
		}
		
		/*== OBSERVAÇÕES PARA OS ALUNOS ==*/
		
		
	  
	  }

?>