<?php
	if(!empty($_GET['id'])){
		
		
		$id    = $_GET['id'];
		$exibe = $_GET['exibe'];
		
		if($exibe == "aula")
			$tabela = "escolar2_aula";
		else 
			$tabela = "escolar2_avaliacao";
			
		$filtervkt = " AND $tabela.vkt_id = '$vkt_id' ";
			
		$consulta = mysql_fetch_object(mysql_query($ty=" SELECT *, $tabela.id AS id_current FROM  $tabela WHERE 1 $filtervkt AND $tabela.id = '$id' "));
		
		
		 /*. TURMA .*/
		  $turma = mysql_fetch_object(mysql_query($ty=" SELECT *, turma.nome AS turma FROM $tabela
		  JOIN 
			  escolar2_professor_has_turma AS professor_turma ON professor_turma.id = $tabela.professor_as_turma_id
		  JOIN
			  escolar2_turmas AS turma ON turma.id = professor_turma.turma_id	
		  WHERE 
			  $tabela.id = '$consulta->id_current'
		  "));
		  
		  /*. MATERIA .*/
		  $result2 = mysql_fetch_object(mysql_query(" SELECT *, materia.nome AS nome_materia FROM escolar2_serie_has_materias AS serie_materia
		  JOIN
		  		escolar2_materias AS materia ON materia.id = serie_materia.materia_id
		  WHERE 
		  		serie_materia.id = '$turma->serie_has_materia_id'
		  "));
		  
		  /*. PROFESSOR .*/	
		  $result3 = mysql_fetch_object(mysql_query("SELECT *,funcionario.nome AS nome_professor FROM escolar2_professores AS professor
		  JOIN
		  		rh_funcionario AS funcionario ON funcionario.id = professor.funcionario_id
		  WHERE 
		  		professor.id = '$turma->professor_id'	
		"));
		
		/*. SERIE .*/
		$serie = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_series WHERE id = '$turma->serie_id' "));
		
		/*. UNIDADE .*/
		$unidade = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_unidades WHERE id = '$turma->unidade_id' "));
			
	}
	if($_POST['action'] == "Salvar"){
			AlteraStatus($_POST);
	}
?>