<?php


if($_GET['professor_as_turma']>0 ){
	$professor_turma=mysql_fetch_object(mysql_query("SELECT * FROM escolar2_professor_has_turma WHERE vkt_id='$vkt_id' AND id='{$_GET['professor_as_turma']}'"));
	echo mysql_error();
	$turma=mysql_fetch_object(mysql_query("SELECT * FROM escolar2_turmas WHERE vkt_id='$vkt_id' AND id='$professor_turma->turma_id'"));
	$unidade = mysql_fetch_object(mysql_query("SELECT * FROM escolar2_unidades WHERE vkt_id='$vkt_id' AND id='$turma->unidade_id'"));
}
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
	 if($_GET['sala'] > 0 and $_GET['materia'] > 0){
				$sala    = $_GET['sala'];
				$materia = $_GET['materia'];
				$periodo_avaliacao = $_GET['periodo_avaliacao'];
				$r_matricula = mysql_query(" SELECT * FROM escolar_matriculas WHERE sala_id = '$sala' AND pago = 'S' "); 
				
				
				 $smp = mysql_fetch_object(mysql_query($rt=" SELECT * FROM escolar_sala_materia_professor 
												WHERE sala_id  = '{$_GET['sala']}' 
												AND materia_id = '{$_GET['materia']}' AND vkt_id = '$vkt_id' "));
					
	 }
	 
		
	 /*if($_GET['aula'] > 0){
			$aula = $_GET['aula'];
			
				$sql_aula = mysql_query("SELECT * FROM escolar_notas WHERE avaliacao_id = '$aula'");	 
	 }*/
	 
	 if($_GET['periodo_id'] > 0){
			$_SESSION['periodo_id'] = $_GET['periodo_id']; 	 
	 }
	 
	 /*if($_GET['id'] > 0){
		$id = $_GET['id'];
				$r = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_aula WHERE id = '$id' ")); 
				
						$data = explode(" ",$r->data);
				
	  }*/
	  

?>