<?php
define("TBL_RESERVA", "campo_futebol_reserva");
define("TBL_ITEM_RESERVA","campo_futebol_reserva_horarios");
define("VKT_ID", $vkt_id);

	function CadastraReservaCampo($campos){
			$dados = $_POST;
			
			
			$sql = mysql_query(" INSERT INTO ".TBL_RESERVA." SET 
			vkt_id                = '".VKT_ID."',
			cliente_fornecedor_id = '".$campos["cliente_id"]."', 
			cliente_vekttor_id    = '".$vkt_id."', 
			data_cadastro_reserva = '".dataBrToUsa($dados["data_reserva"])." ".date("H:i:s")."',
			valor                 = '".$campos["valor_reserva"]."',
			valor_reserva         = '".$campos["valor_entrada"]."', 
			status                = 'reserva', 
			local_pagamento       = 'campo' ");
			$reserva_id = mysql_insert_id();
			$dados["reserva_id"] = $reserva_id;
			CadastraItemReserva($dados);
			$config=mf(mq("SELECT * FROM campo_futebol_reserva_config_pagamento WHERE vkt_id='".VKT_ID."' LIMIT 1"));
			//$tem_pgto = mf(mq("SELECT * FROM financeiro_movimento WHERE cliente_id='".VKT_ID."' AND origem_id='$reserva_id' AND origem_tipo='reserva_campo'"));
			if($dados['efetivar_movimento']==1){$efetivar=1;}else{$efetivar=0;};
			if($dados['efetivar_movimento2']==1){$efetivar2=1;}else{$efetivar2=0;};
			
			
			//Financeiro Movimento Valor Total
			pagarReceberInsert(VKT_ID,
							0/* id */,
							$campos['conta_id'] /* conta_id */,
							$campos["cliente_id"],
							array($config->centro_custo_id),
							array('centro_custo'),
							$campos['valor_reserva'],
							dataBrToUsa($dados["data_reserva"]),
							'',
							"Reserva de campo {$dados['data_reserva']} "/*descricao*/,
							"Reserva de campo {$dados['data_reserva']}"/*nota*/,
							$reserva_id/*DOC*/,
							$dados['forma_pagamento_id2']/* forma de pagamento */,
							$campos["valor_reserva"],
							'receber',
							"",
							array($config->plano_conta_id)/*$plano_de_conta_id*/,
							array('centro_custo')/*$plano_de_conta*/,
							$campos['valor_reserva']/*$plano_valor*/,
							'Salvar',
							$efetivar2,
							dataBrToUsa($dados["data_info_movimento2"]),
							$reserva_id,
							"reserva_campo");
		
		
		//Financeiro Movimento Entrada da Reserva					
		pagarReceberInsert(VKT_ID,
							0/* id */,
							$campos['conta_id'] /* conta_id */,
							$campos["cliente_id"],
							array($config->centro_custo_id),
							array('centro_custo'),
							$campos['valor_entrada'],
							dataBrToUsa($dados["data_reserva"]),
							'',
							"Entrada Reserva de campo {$dados['data_reserva']} "/*descricao*/,
							"Entrada Reserva de campo {$dados['data_reserva']}"/*nota*/,
							$reserva_id/*DOC*/,
							$dados['forma_pagamento_id']/* forma de pagamento */,
							$campos["valor_entrada"],
							'receber',
							"",
							array($config->plano_conta_id)/*$plano_de_conta_id*/,
							array('centro_custo')/*$plano_de_conta*/,
							$campos['valor_entrada']/*$plano_valor*/,
							'Salvar',
							$efetivar,
							dataBrToUsa($dados["data_info_movimento"]),
							$reserva_id,
							"reserva_campo");
	}
	
	function UpadteReserva($campos){
			$dados = $_POST;
			$sql = mysql_query(" UPDATE ".TBL_RESERVA." SET 
			vkt_id                = '".VKT_ID."',
			cliente_fornecedor_id = '".$campos["cliente_id"]."', 
			cliente_vekttor_id    = '".$vkt_id."', 
			data_cadastro_reserva = '".dataBrToUsa($dados["data_reserva"])." ".date("H:i:s")."',
			valor                 = '".moedaBrTousa($campos["valor_reserva"])."', 
			status                = 'reserva', 
			local_pagamento       = 'campo'
			WHERE id='{$dados['id']}'
			 ");
			//$reserva_id = mysql_insert_id();
			$reserva_id=$dados['id'];
			$dados['reserva_id']=$reserva_id;
			CadastraItemReserva($dados);
			if($campos['status_pagamento']=='pendente'){
			$config=mf(mq("SELECT * FROM campo_futebol_reserva_config_pagamento WHERE vkt_id='".VKT_ID."' LIMIT 1"));
			if($dados['efetivar_movimento']==1){$efetivar=1;}else{$efetivar=0;};
			if($dados['efetivar_movimento2']==1){$efetivar2=1;}else{$efetivar2=0;};
			$tem_pgto_finalizado 	= mysql_query("SELECT * FROM financeiro_movimento WHERE cliente_id='".VKT_ID."' AND origem_id='$reserva_id' AND origem_tipo='reserva_campo' AND status='1'");
			//echo mysql_num_rows($tem_pgto_finalizado);
			if(mysql_num_rows($tem_pgto_finalizado)<=1){
				mysql_query($a="DELETE FROM financeiro_movimento WHERE cliente_id='".VKT_ID."' AND origem_id='$reserva_id' AND origem_tipo='reserva_campo' AND status='0' ");
				
					//Financeiro Movimento Valor Total
			//echo "oi3";
			if(!isset($_POST['pagou_total'])){
				//echo "oi2";
			pagarReceberInsert(VKT_ID,
							0/* id */,
							$campos['conta_id'] /* conta_id */,
							$campos["cliente_id"],
							array($config->centro_custo_id),
							array('centro_custo'),
							$campos['valor_reserva'],
							dataBrToUsa($dados["data_reserva"]),
							'',
							"Reserva de campo {$dados['data_reserva']} "/*descricao*/,
							"Reserva de campo {$dados['data_reserva']}"/*nota*/,
							$reserva_id/*DOC*/,
							$dados['forma_pagamento_id2']/* forma de pagamento */,
							$campos["valor_reserva"],
							'receber',
							"",
							array($config->plano_conta_id)/*$plano_de_conta_id*/,
							array('centro_custo')/*$plano_de_conta*/,
							$campos['valor_reserva']/*$plano_valor*/,
							'Salvar',
							$efetivar2,
							dataBrToUsa($dados["data_info_movimento2"]),
							$reserva_id,
							"reserva_campo");
			}
			
			if(!isset($_POST['pagou_entrada'])){
				pagarReceberInsert(VKT_ID,
							0/* id */,
							$campos['conta_id'] /* conta_id */,
							$campos["cliente_id"],
							array($config->centro_custo_id),
							array('centro_custo'),
							array($campos['valor_entrada']),
							dataBrToUsa($dados["data_reserva"]),
							'',
							"Reserva de campo {$dados['data_reserva']} "/*descricao*/,
							"Reserva de campo {$dados['data_reserva']}"/*nota*/,
							$reserva_id/*DOC*/,
							$dados['forma_pagamento_id']/* forma de pagamento */,
							$campos["valor_entrada"],
							'receber',
							"",
							array($config->plano_conta_id)/*$plano_de_conta_id*/,
							array('centro_custo')/*$plano_de_conta*/,
							array($campos['valor_entrada'])/*$plano_valor*/,
							'Salvar',
							$efetivar,
							dataBrToUsa($dados["data_info_movimento"]),
							$reserva_id,
							"reserva_campo");
			}//if
			}
			}
			
	}
	
	function CadastraItemReserva( $dados = array() ){
		
		$campos =  $dados["campo"];
		$reserva_id = $dados["reserva_id"];
		mysql_query("DELETE FROM ".TBL_ITEM_RESERVA." WHERE reserva_id={$reserva_id}");
		
		for($i=0; $i < count($dados["campo"]); $i++ ){
			
			for($j=0; $j <count($dados["horario_reserva"]);$j++){
				
				$sql = " INSERT INTO ".TBL_ITEM_RESERVA." SET 
					reserva_id = {$reserva_id},
					campo_id   = {$dados[campo][$i]},
					data_hora  = '".dataBrToUsa($dados["data_reserva"]).": ".$dados["horario_reserva"][$j]."' ";
				
				mysql_query($sql);
				//echo $sql." ".mysql_error();
			}
		}
		
	}
	
	function DeleteReserva($id){
		
		$sql = mysql_query(" DELETE FROM ".TBL_RESERVA." WHERE id = {$id} ");
		
		$sqlItem = mysql_query(" DELETE FROM ".TBL_ITEM_RESERVA." WHERE reserva_id = {$id} ");
	}
	
	function ConsultaCampoHorario($hora, $data_reserva){ /* deprecated */
			
			$sql= mysql_query($t=" SELECT *,campo.nome AS nome_campo FROM  ".TBL_ITEM_RESERVA." AS horarios 
			JOIN campo_futebol AS campo ON campo.id = horarios.campo_id
			JOIN ".TBL_RESERVA." AS reserva ON reserva.id = horarios.reserva_id
			JOIN cliente_fornecedor AS cliente ON cliente.id = reserva.cliente_fornecedor_id 
			
			WHERE DATE_FORMAT(horarios.data_hora, '%H:%i') = '".$hora."' 
			AND DATE_FORMAT(horarios.data_hora, '%d/%m/%Y' ) = '".$data_reserva."' ");
			
			while($campos=mysql_fetch_array($sql)){
				 $campo_nome["nome"][] = $campos["nome_campo"];
				 $campo_nome["razao"][] = $campos["razao_social"];	
			}
			
			return ($campo_nome);
			
	}

?>