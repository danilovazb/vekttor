<?php

	global $vkt_id;
 	$busca =  !empty($_GET["busca"])  ? $_GET["busca"] : NULL;
	 
	 if($_POST['salva_formulario_contrato_cliente']== '1'){
		   
		   if( !empty($_POST["relatorio_id"]) )
		     update_relatorio($_POST);
		   else
		   	cadastra_relatorio_individual($_POST);
			
	 }
	 
	 if( $_POST["action"] == "Importar" ){
		ImportarArquivo(); 
	 }
	  if( $_POST["action"] == "Exportar" ){
		ExportarArquivo(); 
	 }
	 
	 
	 if($_GET['id'] > 0){
		$id = $_GET['id'];
		$r = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar2_avaliacao WHERE id = '$id' ")); 
		$data = explode(" ",$r->data);
				
	  }
	  
	  if( !empty($_GET["turma_id"]) ){
		 
		 $bimestre_id = $_GET["bimestre_id"];
		 $unidade_id  = $_GET["unidade_id"];
		 $ensino_id   = $_GET["ensino_id"];
		 $turma_id    = $_GET["turma_id"];
		 $professor_has_turma = $_GET["professor_has_turma"];
		 
		 $array_avaliacoes = lista_avaliacao_bimestre($bimestre_id, $unidade_id,$ensino_id);
		 
		 $array_alunos_avaliacao = lista_alunos_para_avaliacao($_GET["turma_id"],$busca);
		 
		 $info_bimestre = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_periodos_avaliacao WHERE id = '$bimestre_id' AND vkt_id = '$vkt_id' ")); 
		 
		
		/* Somente para recuperar o nome da turma e da materia */
		 $s_professor_has_turma = mysql_fetch_object(mysql_query(" 
		  SELECT 
		  turma.nome AS nome_turma,
		  materia.nome AS nome_materia 
		  FROM escolar2_professor_has_turma AS prof_turma 
		 	
		  JOIN escolar2_turmas AS turma
			ON prof_turma.turma_id = turma.id 
		  
		  JOIN escolar2_serie_has_materias AS serie_materia 	
		 	ON prof_turma.serie_has_materia_id = serie_materia.id
			
		  JOIN escolar2_materias AS materia
		  	ON serie_materia.materia_id = materia.id   	
			
			WHERE prof_turma.id = '$professor_has_turma' "));
	  
	  }
	  
	  if( !empty($_GET["relatorio_id"]) ){
		  $id = $_GET["relatorio_id"];
			$info_relatorio = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_relatorio_individual_bimestre WHERE id = ' $id' "));  
	  }
	 
	 
	/* if($_GET['avaliacao_id'] > 0){
			$avaliacao_id = $_GET['avaliacao_id'];
			
			$avaliacao = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar2_avaliacao AS avaliacao 
		JOIN 
			escolar2_professor_has_turma AS professor_turma ON professor_turma.id = avaliacao.professor_as_turma_id
		WHERE
			avaliacao.id = '$avaliacao_id' "));
			
			
			// consulta na tabela matricula para pegar todos os alunos dessa turma
			$sql_turma_avaliacao = mysql_query(" SELECT * FROM escolar2_matriculas WHERE turma_id = '$avaliacao->turma_id' ");
			
			//Consulta na teble Turma
			$turma = mysql_fetch_object(mysql_query(" SELECT *, unidade.nome AS und_nome, turma.nome AS nome_turma FROM escolar2_turmas AS turma
			JOIN 
				escolar2_unidades AS unidade ON unidade.id = turma.unidade_id
				   				
			WHERE turma.id = '$avaliacao->turma_id' "));
			
			
		
		/*=== SÉRIE MATÉRIA ===*/	
		
		/*$sql_serie_materia = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_serie_has_materias AS serie_materia
		JOIN
			escolar2_materias AS materia ON materia.id = serie_materia.materia_id 
		WHERE 
			serie_materia.id = '$avaliacao->serie_has_materia_id ' ")); 
		
		
		/*=== NOTAS ===*/
		
		//consulta na tabela FREQUENCIA	para verificar se ja existe registro para a aula
		/*$sql_nota = mysql_query(" SELECT * FROM escolar2_aluno_as_avaliacao WHERE avaliacao_id = '$avaliacao_id' ");
		$sql_turma_nota = mysql_query(" SELECT * FROM escolar2_matriculas WHERE turma_id = '$avaliacao->turma_id' ");
		
		if(mysql_num_rows($sql_nota) == 0){
		
			while($avaliacao_turma = mysql_fetch_object($sql_turma_nota)){
					
				mysql_query(" INSERT INTO escolar2_aluno_as_avaliacao SET 
				vkt_id = '$vkt_id',
				avaliacao_id = '$avaliacao_id',
				matricula_aluno_id = '$avaliacao_turma->id',
				nota   = '',
				status = '1' ");
					
			}
		}
			
	 } /* Fim de $_GET['avaliacao_id'] */

?>