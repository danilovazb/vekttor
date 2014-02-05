<?php

	if($_GET['materia'] > 0){
		$_SESSION['materia_id'] = $_GET['materia']; 
		$materia = consulta_materia($_GET['materia']);	
	}
	if($_POST['action'] == 'Salvar'){
			if($_POST['id'] > 0){
				altera_aula($_POST);
				//echo "altera";
			}else{
				$aula=insere_aula($_POST);
				insere_frequencia($_GET,$aula);
				//echo "cadastra";
			}
	 }
	 if($_POST['action']== 'Excluir'){
			deletar_aula($_POST['id']);
	 }
	 
/*------------------------------ RECEBE VALORES ----------------------------------*/
	 if(!empty($_GET['sala_materia'])){
		 $smp = mysql_fetch_object(mysql_query(" SELECT * FROM  escolar_sala_materia_professor WHERE id = '{$_GET['sala_materia']}' "));
	 }
	 if($_GET['sala'] > 0){
				$sala = $_GET['sala'];
			    $_SESSION['sala'] = $sala;
				$_SESSION['sala_materia'] = $_GET['sala_materia'];
				$qtdAula = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtdAula FROM escolar_aula WHERE sala_materia_professor_id = '".$_GET['sala_materia']."'"));
				$count_sala = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtd_aluno FROM escolar_matriculas WHERE sala_id = '$sala' AND pago = 'S' "));
				$sql_sala = mysql_query(" SELECT * FROM escolar_matriculas WHERE sala_id = '$sala' AND pago = 'S' "); 		
	 }
	 if($_GET['aula'] > 0){
			$aula = $_GET['aula'];
			$sql_aula = mysql_query("SELECT * FROM escolar_notas WHERE avaliacao_id = '$aula'");	 
	 }
	 
	 if($_GET['periodo_id'] > 0){
			$_SESSION['periodo_id'] = $_GET['periodo_id']; 	 
	 }
	 
	 if($_GET['id'] > 0){
		$id = $_GET['id'];
				$r = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_aula WHERE id = '$id' ")); 
				
				
	  }

?>