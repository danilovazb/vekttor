<?php

	if($_GET['materia'] > 0){
		$_SESSION['materia_id'] = $_GET['materia']; 
		$materia = consulta_materia($_GET['materia']);	
	}
	if($_POST['action'] == 'Salvar'){
			if($_POST['id'] > 0){
				atualiza_forum_resposta($_POST);
				//echo "atualiza_forum_resposta";
			}else{
				//$aula=insere_aula($_POST);
				//insere_frequencia($_GET,$aula);
				//echo "cadastra";
			}
	 }
	 if($_POST['action']== 'Excluir'){
			deletar_aula($_POST['id']);
	 }
	 if($_GET['sala'] > 0){
				$sala = $_GET['sala'];
				$sql_sala = mysql_query(" SELECT * FROM escolar_matriculas WHERE sala_id = '$sala' AND pago = 'S' "); 		
	 }
	
	 
	 if($_GET['periodo_id'] > 0){
			$_SESSION['periodo_id'] = $_GET['periodo_id']; 	 
	 }
	 
	 if($_GET['id'] > 0){
		 $id = $_GET['id'];
		$consulta_forum = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_forum WHERE id = '$id' AND vkt_id = '$vkt_id' "));
		$consulta_aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_alunos WHERE id = '$consulta_forum->aluno_id' "));
		$consulta_aula  = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_aula  WHERE id = '$consulta_forum->aula_id'"));	
		$pergunta       = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_forum_pergunta WHERE id = '$consulta_forum->pergunta_id'"));		
	  }

?>