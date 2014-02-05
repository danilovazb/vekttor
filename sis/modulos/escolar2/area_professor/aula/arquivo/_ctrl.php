<?php
	$id_progresso = md5(microtime() . rand());
	if($_POST['action'] == 'Salvar'){
			
			if($_POST['id'] > 0){
				altera_aula($_POST);
			}else if($_POST['insere'] > 0){
				$aula=insere_arquivo();
			}
			
	 }
	 if($_POST['action']== 'Excluir'){
			deletar_aula($_POST['id']);
	 }
	 
	 if($_GET['id'] > 0){
		$id = $_GET['id'];
		$r = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar2_aula WHERE id = '$id' ")); 			
				
	  }

?>