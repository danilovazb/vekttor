<?php
include("../../../_config.php");
	
	$acao = $_POST["acao"];
	
	if($acao == "serie_has_turma"){
		//$dados = array();
		
		$serie_id = $_POST["serie_id"];
		
		$sql_turma = mysql_query($t=" SELECT * FROM escolar2_turma WHERE serie_id = '$serie_id'  ");
		
		$qtd = mysql_num_rows($sql_turma);
		
		if($qtd > 0){
			$html_list = "";
			
			while($turma=mysql_fetch_object($sql_turma)){
				
				//$dados_Array['id']   = $turma->id;
				//$dados_Array['nome'] = $turma->nome;
				//$dados[] = $dados_Array;
				
				$html_list .= "<option value=".$turma->id.">".$turma->nome."</option>";
				
			}
			echo $html_list;
		}
		
		//echo json_encode($dados); 
		
	}


?>