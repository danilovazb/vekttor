<?php

  /*
  	Função criada por Jaime Neves
  */
  function cadastraAgenda($campos){
	  global $vkt_id;
	  global $usuario_id;
	  $sql=" INSERT INTO agenda SET nome = '$campos[nome_agenda]',vkt_id = '$vkt_id' ,usuario_id = '$usuario_id'";
	  mysql_query($sql);
  }

  /*
  	Função criada por Jaime Neves
  */
  function diferenca_data($data_inicio = NULL, $data_fim = NULL){
	 if( !empty($data_inicio) and !empty($data_fim) ){
			
		list($dia_i, $mes_i, $ano_i) = explode("/", $data_inicio); //Data inicial 
		list($dia_f, $mes_f, $ano_f) = explode("/", $data_fim); //Data final 
		$mk_i = mktime(0, 0, 0, $mes_i, $dia_i, $ano_i); // obtem tempo unix no formato timestamp 
		$mk_f = mktime(0, 0, 0, $mes_f, $dia_f, $ano_f); // obtem tempo unix no formato timestamp
		
		$diferenca = $mk_f - $mk_i; //Acha a diferença entre as datas
		
		return $diferenca; 
		  
	 } 
  }
 
  /*
  	Função criada por Jaime Neves
  */
  function updateAgenda($campos){
	  $sql = " UPDATE agenda SET nome = '$campos[nome_agenda]' WHERE id = '$campos[id]'";
	  mysql_query($sql);
  }
  
  
  /*
  	Função criada por Jaime Neves
  */
  function cadastraEvento($campos){
		global $vkt_id; 
		
		if(empty($campos['cliente_id']))
			$campos['cliente_id'] = cadastraCliente($campos);
		
		$diferenca_data =  diferenca_data($campos['data_inicio'],$campos['data_fim']);
		  
		  if($diferenca_data > 0){
			  alert( utf8_decode(" Data fim maior que data início (corrigir)"));
		  } else { 
			  /* Insere na Tabela agenda_agendamento */
			  $sql_agendamento = (" INSERT INTO agenda_agendamento SET
				vkt_id         = '$vkt_id',
				agenda_id      = '$campos[agenda_id]',
				cliente_id     = '$campos[cliente_id]',
				nota_adicional = '$campos[evento]',
				data_hora_inicio = '".dataBrToUsa($campos['data_inicio'])." ".$campos['hora_inicio']."',
				data_hora_fim    = '".dataBrToUsa($campos['data_fim'])." ".$campos['hora_fim']."' ");								  
			  mysql_query($sql_agendamento);
		  }
  }

  /*
  	Função criada por Jaime Neves
  */
  function updateEvento($campos){
	global $vkt_id;
	
	$diferenca_data =  diferenca_data($campos['data_inicio'],$campos['data_fim']);
	
	  if($diferenca_data > 0){
				  alert( utf8_decode(" Data fim maior que data início (corrigir)"));
	  } else { 
		  $sql = (" UPDATE agenda_agendamento SET
					  vkt_id         = '$vkt_id',
					  agenda_id      = '$campos[agenda_id]',
					  cliente_id     = '$campos[cliente_id]',
					  nota_adicional = '$campos[evento]',
					  data_hora_inicio = '".dataBrToUsa($campos['data_inicio'])." ".$campos['hora_inicio']."',
					  data_hora_fim    = '".dataBrToUsa($campos['data_fim'])." ".$campos['hora_fim']."'
				  WHERE 
					  id = '$campos[id]' ");
			mysql_query($sql);
	  }
  }

  /*
  	Função criada por Jaime Neves
  */
  function cadastraCliente($campos){
	  global $vkt_id;
	  $sql = " INSERT INTO cliente_fornecedor SET razao_social = '$campos[nome_cliente]', nome_fantasia = '$campos[nome_cliente]'";
	  mysql_query($sql);
	  $cliente_id = mysql_insert_id();
	  return $cliente_id;
  }
  
  /*
  	Função criada por Jaime Neves
  */
  function ExcluiEvento($id){
			  global $vkt_id;
			  mysql_query(" DELETE FROM agenda_agendamento WHERE id = '$id' AND vkt_id = '$vkt_id'");
  }
  
  
  /*
  	Função criada por Jaime Neves
  */
  function ExcluirAgenda($id){
	  global $vkt_id;
	  mysql_query(" DELETE FROM agenda WHERE id = '$id' AND vkt_id = '$vkt_id'");
  }
  
?>