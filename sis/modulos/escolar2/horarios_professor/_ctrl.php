<?php


	if( !empty($_GET["turma_id"]) ){
		
		$turma_id          = $_GET["turma_id"];	
		$serie_has_materia = $_GET["serie_has_materia"];
		$professor_id      = $_GET["professor_id"];
		$data              = $_GET["data"];
		
		$info_professor = professor_turma_id($professor_id,$turma_id,$serie_has_materia);
		
		$array_horarios = retorna_horarios($professor_id, $serie_has_materia,$info_professor["professor_has_turma_id"]);
		
		$nome_materia = nome_materia($serie_has_materia);
		
	}
	
	if( !empty($_GET["aula_id"]) ){
		$aula_id = $_GET["aula_id"];
		$info_aula = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_aula WHERE id = '".$_GET["aula_id"]."' ")); 	
	}
	
	/* Inserçao */
	
	if($_POST['action'] == 'Salvar'){
		insere_aula($_POST);
	 }

?>