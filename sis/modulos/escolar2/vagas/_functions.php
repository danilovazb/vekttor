<?php
function manipula_turma($dados){
	
	global $vkt_id;
	mysql_query($t="INSERT INTO escolar2_turmas SET 
						vkt_id='$vkt_id',
						sala_id={$dados['sala_id']},
						unidade_id={$dados['escola_id']},
						serie_id={$dados['serie_id']},
						horario_id='{$dados['horario_id']}',
						periodo_letivo_id='{$dados['periodo_letivo_id']}',
						nome='{$dados['nome_turma']}',
						valor_matricula='".moedaBrToUsa($dados['valor_matricula'])."',
						valor_mensalidade='".moedaBrToUsa($dados['valor_mensalidade'])."'
						");
	//echo mysql_insert_id();
}

function editar_turma($dados){
	if($dados['turma_id']>0){
		mysql_query($t=" 
		UPDATE escolar2_turmas  SET 
		  nome='".$dados['nome_turma']."',
		  valor_matricula='".moedaBrToUsa($dados['valor_matricula'])."',
		  valor_mensalidade='".moedaBrToUsa($dados['valor_mensalidade'])."'
		 WHERE
		  id='{$dados['turma_id']}' ");	
		
	}
}

function excluir_turma($id){
	global $vkt_id;
	mysql_query($t="DELETE FROM escolar2_turmas WHERE vkt_id='$vkt_id' AND id='$id' ");
}


//-------Funções do Período Letivo------------------------------------------------------

function manipula_perido_letivo($dados){

	global $vkt_id;
	
	if(!$dados['id'] > 0){
	
		$inicio = "INSERT INTO";
		$fim="";
		
	}else{
	
		$inicio = "UPDATE";
		$fim="WHERE id='".$dados['id']."'";
	
	}
	
	mysql_query($t = "$inicio 
			escolar2_periodo_letivo 
		  SET 
		  	vkt_id='$vkt_id', 
			nome = '{$dados['nome_periodo_letivo']}',
			data_inicio = '".DataBrToUsa($dados['data_inicio_periodo_letivo'])."', 
			data_fim = '".DataBrToUsa($dados['data_termino_periodo_letivo'])."'
			$fim
		");

	//echo $t." ".mysql_error();
}

function deleta_perido_letivo($id){

	mysql_query("DELETE FROM escolar2_periodo_letivo WHERE id='$id'");

}

//-------Funções do Horário------------------------------------------------------

function manipula_horario($dados){

	global $vkt_id;
	
	if(!$dados['id'] > 0){
	
		$inicio = "INSERT INTO";
		$fim="";
		
	}else{
	
		$inicio = "UPDATE";
		$fim="WHERE id='".$dados['id']."'";
	
	}
	
	mysql_query($t = "$inicio 
			escolar2_horarios 
		  SET 
		  	vkt_id='$vkt_id', 
			nome = '{$dados['nome_periodo_letivo']}',
			hora_inicio = '".$dados['hora_inicio']."', 
			hora_fim = '".$dados['hora_termino']."',
			combinar_horario = '".$dados['combine']."'
			$fim
		");

	//echo $t." ".mysql_error();
}

function deleta_horarios($id){
	global $vkt_id;
	mysql_query("DELETE FROM escolar2_horarios WHERE id='$id' AND vkt_id='$vkt_id'");

}

/* IMPORTAÇÃO DE PERÍODO - add jaime */
  
  function RetornaSlashes($string){
	  
	  $stringFind = "'";
	  $pos = strripos($string, $stringFind);
			  
	  if (  !($pos === false)) 
		  return  addslashes($string);
	   else
		  return $string;	
	  
  }

  function importar_turmas($periodo_exportacao_id = NULL, $periodo_importacao_id = NULL ){
	
	global $vkt_id;
	
	$result = verifica_periodo_importado($periodo_importacao_id);
	
	if($result == NULL){
	
	if( ($periodo_exportacao_id !=  $periodo_importacao_id) and !empty($periodo_exportacao_id) and !empty($periodo_importacao_id) ){ 
	
		$sql = mysql_query("SELECT * FROM escolar2_turmas WHERE vkt_id = '$vkt_id' AND periodo_letivo_id = '$periodo_exportacao_id'  ");
	    $num_reg = mysql_num_rows($sql);
		
		if( $num_reg > 0 ){
		
		while($dados_turma=mysql_fetch_row($sql)) {	
			$temp_turma[] = $dados_turma;
		}
		
		foreach($temp_turma as $dado => $value){
		   
		   $value[7] = $periodo_importacao_id; // posicao 7 é a posição do Periodo Letivo
		   $value[0] = NULL;
		   
		   $sql_turma  = "INSERT INTO escolar2_turmas VALUES ('".implode("', '", array_map("RetornaSlashes",$value))."')";
		   mysql_query($sql_turma);
			
		}
		
		} else {
			alert("Não existe registros nesse período de exportção");
		}
		
	 }
	 
	} else {
	 	alert("Esse Período Letivo já foi importado");	
	} 
	 
	 
  }
  
  function verifica_periodo_importado($periodo_importacao_id = NULL){
	  global $vkt_id;
	  
	  if( !empty($periodo_importacao_id) ){
		  
		  $sql_turmas = mysql_query(" SELECT * FROM escolar2_turmas WHERE vkt_id = '$vkt_id' AND periodo_letivo_id = '$periodo_importacao_id' ");
		  $num_reg = mysql_num_rows($sql_turmas);
		  return $num_reg;
	  }
  }
  
  
  function consulta_turma($horario = NULL, $serie = NULL, $periodo_letivo = NULL, $unidade_id = NULL){
	  global $vkt_id;
	  
		$sql = mysql_query($y=" 
		SELECT 
			turma.id, turma.nome, turma.horario_id, sala.nome AS nome_sala, turma.valor_matricula, turma.valor_mensalidade 
		 FROM escolar2_turmas AS turma
		  JOIN escolar2_salas AS sala ON sala.id = turma.sala_id
		  WHERE turma.vkt_id = '$vkt_id' 
		  AND turma.horario_id = '".$horario."' 
		  AND turma.serie_id = '".$serie."'    
		  AND turma.periodo_letivo_id = '".trim($periodo_letivo)."' 
		  AND turma.unidade_id = '".trim($unidade_id)."' ");
		  
		  while($turmas=mysql_fetch_assoc($sql)){
			$result[] = $turmas;
								
		  }
		  
		  if( count($result) > 0 )
		  return $result;  
  }
  
  function verifica_qtd_turma(array $turma){
	   return count($turma);
  }
  
  function get_nome($nome = NULL, $tamanho = NULL){
	
	if( !empty($nome) and !empty($tamanho) ){
	if( strlen($nome) > $tamanho )
		return substr($nome,0,$tamanho)."...";
	else
		return $nome;
	}
			
  }
  
  function lista_periodo_letivo(){
	 global $vkt_id; 
	 $sql = mysql_query(" SELECT * FROM escolar2_periodo_letivo WHERE vkt_id = '$vkt_id' ");
	 
	 while($periodos=mysql_fetch_assoc($sql)){
		  $periodo[] = $periodos;
     }
	  
	 if(count($periodo) > 0)
	 	return $periodo;
  }
  
  function lista_unidade(){
	 global $vkt_id;
	 
	 $sql = mysql_query(" SELECT * FROM escolar2_unidades WHERE vkt_id = '$vkt_id' ");
  }

?>