<?php
include('../../../../_config.php');


function sanitize($text) {
	$text = htmlspecialchars($text, ENT_QUOTES);
	$text = str_replace("\n\r","\n",$text);
	$text = str_replace("\r\n","\n",$text);
	$text = str_replace("\n","<br>",$text);
	return $text;
}

		
	  $aula      = $_POST['aula'];
	  $matricula = $_POST['matricula'];
	  $presenca  = $_POST['presenca'];
		
		if($_POST['acao'] == 'cad_presenca'){
			  
			  mysql_query(" UPDATE escolar2_frequencia_aula SET 
			  		presenca = '$presenca'
			  	WHERE 
					aula_id = '$aula'
				AND 
					matricula_aluno_id = '$matricula'
				
			  ");
						
		} if($_POST['acao'] == 'retira_presenca'){
			  
			  mysql_query(" UPDATE escolar2_frequencia_aula SET 
			  		presenca = '$presenca'
			  	WHERE 
					aula_id = '$aula'
				AND 
					matricula_aluno_id = '$matricula'
				
			  ");
			
		} if($_POST["acao"] == "presenca_todos"){
			  
			  mysql_query(" UPDATE escolar2_frequencia_aula SET 
			  		presenca = '$presenca'
			  	WHERE 
					aula_id = '$aula'
				AND 
					matricula_aluno_id = '$matricula' ");
			
			
		} if($_POST["acao"] == "retira_presenca_todos"){
			  
			  mysql_query(" UPDATE escolar2_frequencia_aula SET 
			  		presenca = '$presenca'
			  	WHERE 
					aula_id = '$aula'
				AND 
					matricula_aluno_id = '$matricula'
				
			  ");
		} if($_POST["acao"] == "finalizar_chamada"){
			    
				$status = $_POST["status"];
			
				mysql_query(" UPDATE escolar2_frequencia_aula SET status = '$status' WHERE aula_id = '$aula' ");
				mysql_query(" UPDATE escolar2_aula SET status = '2' WHERE id = '$aula' ");
			
		} 
		
		if ($_POST["acao"] == "insere_observacao"){
			
			$observacao =  sanitize($_POST["observacao"]);
			
			if( !empty($observacao) ){
			 
			  
			  $consulta_obs = mysql_query(" SELECT * FROM escolar2_obs_aluno_aula WHERE aula_id = '$aula' AND matricula_aluno_id = '$matricula'  ");
			  
			  $num_reg = mysql_num_rows($consulta_obs);
			  
				  if($num_reg > 0)  
				  	mysql_query($y=" UPDATE escolar2_obs_aluno_aula SET observacao = '".utf8_decode($observacao)."' WHERE aula_id = '$aula' AND matricula_aluno_id = '$matricula'    ");  
				  else 
				  	mysql_query($y=" INSERT INTO escolar2_obs_aluno_aula SET observacao = '".utf8_decode($observacao)."', matricula_aluno_id = '$matricula', aula_id = '$aula'    ");  
				  
			  
			}
		
		}
		
?>