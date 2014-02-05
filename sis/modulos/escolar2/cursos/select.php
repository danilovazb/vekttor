<?php
include("../../../_config.php");
	$acao = $_POST["acao"];

	if($acao == "unidade"){
			
			$periodo_id = $_POST["periodo_id"];
			
			$sql = mysql_query($t=" SELECT DISTINCT(unidade_id) FROM escolar2_turmas WHERE periodo_letivo_id = '$periodo_id' ");
			
			while($turma=mysql_fetch_object($sql)){
				
			$unidade = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_unidades WHERE id = '$turma->unidade_id' "));
					
					echo " <option value='".$unidade->id."'>".utf8_encode($unidade->nome)."</option> ";
				
				
			}
			
	
	} else if($acao == "serie"){
		
	} else if($acao == "turma"){
		
	}

?>
