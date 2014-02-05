<?php
include("../../../_config.php");
include("../../../_functions_base.php");
  
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
	 
	$sql = mysql_query("SELECT * FROM escolar2_turmas WHERE vkt_id = '$vkt_id' AND periodo_letivo_id = '$periodo_exportacao_id'  ");
   
	while($dados_turma=mysql_fetch_row($sql)) {	
		$temp_turma[] = $dados_turma;
	}
	
	
	foreach($temp_turma as $dado => $value){
		 $value[7] = $periodo_importacao_id; // posicao 7 é a posição do Periodo Letivo
		 
		 $sql_turma  .= "INSERT INTO escolar2_turmas ";
		 $sql_turma .= " VALUES ('".implode("', '", array_map("RetornaSlashes",$value))."')"."<br/>";
	  		
	}
	echo $sql_turma;  
	  
  }

	

	/* Salas */
	/*$select_sala = mysql_query(" SELECT * FROM escolar2_salas WHERE vkt_id = '$vkt_id' ");
	$sql = "";
	echo $sql;
	/*while($dados_sala = mysql_fetch_row($select_sala)){
		//$temp_sala[] = $dados_sala; 
	}
	
	/*foreach($temp_sala as $dadoSala => $array_sala){
		$sql_sala  .= "INSERT INTO escolar2_salas ";
		$sql_sala .= " VALUES ('".implode("', '", array_map("RetornaSlashes",$array_sala))."')"."<br/>";
	}
	echo "<br/>".$sql_sala;*/
	  
	

?>