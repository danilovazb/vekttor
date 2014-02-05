<?php
include("../../../_config.php");
include("../../../_functions_base.php");


	function quantidade_turma_sala($sala_id){
			
			$sql = " SELECT * FROM  escolar2_turmas AS turma 
					 JOIN 
						escolar2_salas AS sala ON sala.id = turma.sala_id
					 WHERE 
						turma.sala_id = '$sala_id' ";
		
	}

	$acao = $_POST["acao"];

	if($acao == "periodo"){
			
			$periodo_id = $_POST["periodo_id"];
			
			$sql = mysql_query($t=" SELECT DISTINCT(unidade_id) FROM escolar2_turmas WHERE periodo_letivo_id = '$periodo_id' ");
			
			
			 $html_option = "";
		  	 $html_option .= "<option value='0'>Selecione</option>";
			
			while($turma=mysql_fetch_object($sql)){
				
			$unidade = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_unidades WHERE id = '$turma->unidade_id' "));
					
					$html_option .= " <option value='".$unidade->id."'>".utf8_encode($unidade->nome)."</option> ";
				
				
			}
			echo $html_option;
			
	
	} else if($acao == "unidade"){ // aqui quando seleciona unidade
			
		  $periodo_id = $_POST["periodo_id"];
		  $unidade_id = $_POST["unidade_id"];
		  
		   $sql_count = mysql_query($y1=" SELECT DISTINCT sala_id,id FROM escolar2_turmas WHERE periodo_letivo_id = '$periodo_id' AND unidade_id = '$unidade_id'");
		    
			$qtd_vaga = 0;
		    $qtd_matriculado = 0;
		   	
			while($turmaCount=mysql_fetch_object($sql_count)){
					
					$sala  = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_salas WHERE id = '$turmaCount->sala_id' "));
					$qtd_vaga += $sala->capacidade_pedagogica;
					
					$matricula = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtd_matriculado FROM escolar2_matriculas WHERE turma_id = '$turmaCount->id' "));
					$qtd_matriculado += $matricula->qtd_matriculado;
					
			}
		   
		   $vagas_disponiveis = $qtd_vaga - $qtd_matriculado; 
		   
		   
		   if( $vagas_disponiveis == 0 ){
				$disabled = "disabled='disabled'";   
		   }
		   
		   
		   $sql = mysql_query($y2=" SELECT DISTINCT serie_id FROM escolar2_turmas WHERE periodo_letivo_id = '$periodo_id' AND unidade_id = '$unidade_id'");
		  
		  
		  $html_option = "";
		  $html_option .= "<option value='0'>Selecione</option>";
		  
		  while($turma=mysql_fetch_object($sql)){
			  
			  $sala = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_salas WHERE id = '$turma->sala_id' "));
			  $serie = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_series WHERE id = '$turma->serie_id' "));
			  
			  
			  $html_option .= " <option value='".$serie->id."' ".$disabled." >".utf8_encode($serie->nome)." - Vaga: ".$vagas_disponiveis."</option> ";
			  
		  }
		  echo $html_option;
		 //echo $y2;
			
		
	}
	 
	/*================*/
	
	else if($acao == "serie"){
		
		$periodo_id = $_POST["periodo_id"];
		$unidade_id = $_POST["unidade_id"];
		$serie      = $_POST["serie_id"];
		
			$sql = mysql_query($p1=" SELECT * FROM escolar2_turmas WHERE periodo_letivo_id = '$periodo_id' AND unidade_id = '$unidade_id' AND serie_id = '$serie' ORDER BY nome ASC ");
			
			
			
			$html_option = "";
		    $html_option .= "<option value='0'>Selecione</option>";
			
			while($turma=mysql_fetch_object($sql)){
				
				$count_matricula = mysql_fetch_object(mysql_query(" SELECT COUNT(*) AS qtd_matricula FROM escolar2_matriculas WHERE turma_id = '$turma->id' AND status = 'matricula' "));
				
				$unidade = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_unidades WHERE id = '$turma->unidade_id'"));
				$horario = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_horarios WHERE id = '$turma->horario_id' ORDER BY nome"));
				$sala    = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_salas WHERE id = '$turma->sala_id'"));
				
				$capacidade = ($sala->capacidade_pedagogica - $count_matricula->qtd_matricula);
				 
				$html_option .= " <option value='".$turma->id."' id='option_turma'><blockquote><div style='text-transform:uppercase;'>".utf8_encode($turma->nome)." - ".utf8_encode($horario->nome)." <b>(".$capacidade.")</b>"."</div><blockquote/></option> ";
				
			}
			
			echo $html_option;
		
	} else if($acao == "turma"){
		
		$id = $_POST["turma_id"];
		
		$turma = mysql_fetch_object(mysql_query($s=" 
		SELECT 
			turma.valor_matricula,
			horario.combinar_horario
		FROM escolar2_turmas AS turma 
		
		JOIN escolar2_horarios AS horario
			ON turma.horario_id = horario.id
			
		WHERE turma.id = '$id' "));
		
		//echo moedaUsaToBr($turma->valor_matricula);
		$json["valor_matricula"] = $turma->valor_matricula;
		$json["combinar_horario"] = $turma->combinar_horario;
		$json["sql"] = $s;
		
		$json_retorno[] = $json;
		
		echo json_encode($json_retorno);
	}

?>
