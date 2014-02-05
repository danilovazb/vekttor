<?php

	if($_GET['materia'] > 0){
		$_SESSION['materia_id'] = $_GET['materia']; 
		$materia = consulta_materia($_GET['materia']);	
	}
	/*if($_POST['action'] == 'Salvar'){
			if($_POST['id'] > 0){
				altera_aula($_POST);
				//echo "altera";
			}else{
				insere_aula($_POST);
				//echo "cadastra";
			}
	 }
	 if($_POST['action']== 'Excluir'){
			deletar_aula($_POST['id']);
	 }*/
	 if($_GET['turma'] > 0){
				$turma = $_GET['turma'];		
				$sql_sala = mysql_query(" SELECT * FROM escolar_matriculas WHERE sala_id = '$turma' AND pago = 'S' AND vkt_id = '$vkt_id' ");		
	 }
	 /*if($_GET['aula'] > 0){
			$aula = $_GET['aula'];
			
				$sql_aula = mysql_query("SELECT * FROM escolar_notas WHERE avaliacao_id = '$aula'");	 
	 }
	 
	 if($_GET['periodo_id'] > 0){
			$_SESSION['periodo_id'] = $_GET['periodo_id']; 	 
	 }
	 
	 if($_GET['id'] > 0){
		$id = $_GET['id'];
				$r = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_aula WHERE id = '$id' ")); 
				
				
	  }*/

?>