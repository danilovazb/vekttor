<?php

	if($_GET['materia'] > 0){
		$_SESSION['materia_id'] = $_GET['materia'];
		$materia = consulta_materia($_GET['materia']);	
	}
	if($_GET['sala'] > 0){
				$sala = $_GET['sala'];
				$sql_sala = mysql_query(" SELECT * FROM escolar_matriculas WHERE sala_id = '$sala' AND pago = 'S' "); 		
	 }
	 
	 if($_GET['sala'] > 0 and $_GET['materia'] > 0){
		 
					$sala_materia = mysql_fetch_object(mysql_query($rt=" SELECT * FROM escolar_sala_materia_professor 
												WHERE sala_id  = '{$_GET['sala']}' 
												AND materia_id = '{$_GET['materia']}' AND vkt_id = '$vkt_id' "));	 
	 }
	 
	if($_POST['action'] == 'Salvar'){
			if($_POST['id'] > 0){
				altera_avaliacao($_POST);
				//echo "altera";
			}else{
				insere_avaliacao($_POST);
				//echo "cadastra";
			}
	 }
	 if($_POST['action']== 'Excluir'){
			deletar_avaliacao($_POST['id']);
	 }
	 
	 
	 
	 if($_GET['periodo_id'] > 0){
		 	$_SESSION['periodo_id'] = $_GET['periodo_id'];
					$sql_periodo = mysql_fetch_object(mysql_query("SELECT * FROM escolar_periodos WHERE id = '{$_GET['periodo_id']}' AND vkt_id = '$vkt_id' "));
	 }
	 if($_GET['avaliacao'] > 0){
			$avaliacao = $_GET['avaliacao'];
			
				$sql_avaliacao = mysql_query("SELECT * FROM escolar_notas WHERE avaliacao_id = '$avaliacao'");	 
	 }
	 
	 if($_GET['id'] > 0){
		$id = $_GET['id'];
				$r = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_avaliacao WHERE id = '$id' ")); 
				
						$data = explode(" ",$r->data);
				
	  }

?>