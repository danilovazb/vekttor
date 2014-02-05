<?php
include("../../../_config.php");
include("../../../_functions_base.php");


	$funcao = $_REQUEST["funcao"];
	$funcao();
	
	function CadastraEquipamento(){
		global $vkt_id;
		$dados = $_POST["dados_form"];
		
		if( empty($dados["equipamento_id"]) ){
		
			$sql = " INSERT INTO os_equipamento SET 
			vkt_id = '$vkt_id',
			nome   = '".utf8_decode($dados['equipamento'])."',
			modelo = '".utf8_decode($dados['modelo'])."',
			marca  = '".utf8_decode($dados['marca'])."',
			numero_serie = '$dados[numero_serie]' ";
			
			mysql_query($sql);
			$ultimoID = mysql_insert_id();
			$json["equipamentoID"] = $ultimoID;
			$dados["equipamento_id"] = $ultimoID;
			
			if( !empty($dados["os_id"]) )
				$json["ItemID"] = CadastraItemEquipamento($dados);
				
				echo json_encode($json);
		
		} else {
			$equipamento = mysql_fetch_object(mysql_query(" SELECT * FROM  os_equipamento WHERE id = '$dados[equipamento_id]' "));
			$json["equipamentoID"] = $equipamento->id;
				
			if( !empty($dados["os_id"]) )
				$json["ItemID"] = CadastraItemEquipamento($dados);
				
				echo json_encode($json);
		}
	}
	
	function AtualizaEquipamento(){
		global $vkt_id;
		$dados = $_POST["dados_form"];
		
		$sql = " UPDATE os_equipamento SET 
		  vkt_id = '$vkt_id',
		  nome   = '$dados[equipamento]',
		  modelo = '$dados[modelo]',
		  marca  = '$dados[marca]',
		  numero_serie = '$dados[numero_serie]' 
		WHERE 
		  id = '$dados[equipamento_id]' ";
		
		mysql_query($sql);
		
	}
	
	function DeleteItemEquipamento(){
		$id = $_POST["id"];
		$sql = " DELETE FROM os_has_equipamento WHERE id = '$id' ";	
		mysql_query($sql);
	}
	
	function AtualizaItemEquipamento(){
		$dados = $_POST["dados"];
		
		$sql = " UPDATE os_has_equipamento SET ".$dados["NameColumn"]." = '".utf8_decode($dados["TextAtualizar"])."' WHERE os_id = ".$dados["os_id"]." AND equipamento_id = ".$dados["equipamento_id"]."   ";
		mysql_query($sql);
		echo $sql;
		 	
	}
	
	function CadastraItemEquipamento($dados){
		global $vkt_id;
		$sql = " INSERT INTO  os_has_equipamento SET 
		vkt_id = '$vkt_id', 
		os_id  = ".$dados["os_id"].",
		equipamento_id = ".$dados["equipamento_id"].",
		solicitacao_defeito = '".utf8_decode($dados["solicitacao_defeito"])."',
		diagnostico_laudo   = '".utf8_decode($dados["diagnostico_laudo"])."',
		estado_equipamento  = '".utf8_decode($dados["estado_equipamento"])."',
		data_cadastro = now() ";
		
		mysql_query($sql);	
		$UltimoIDItem = mysql_insert_id();
		return $UltimoIDItem;
	}
	
	function ListNumeroSerie(){
		global $vkt_id;
		$numSerie = $_POST["numSerie"];	
		$sql = " SELECT * FROM os_equipamento WHERE  vkt_id = '$vkt_id' AND numero_serie = '".trim($numSerie)."'  ";
		$rows = mysql_query($sql);
		
		while($equipamento=mysql_fetch_array($rows)){
			
			$json["id"] = $equipamento["id"];
			$json["nome"] = utf8_encode($equipamento["nome"]);
			$json["modelo"] = $equipamento["modelo"];
			$json["marca"] = $equipamento["marca"];
			$json["numero_serie"] = $equipamento["numero_serie"]; 
			
			$sqlHistorico = mysql_query(" SELECT *,DATE_FORMAT(data_cadastro, '%d/%m/%Y') AS dataCadastro FROM os_has_equipamento WHERE equipamento_id = '".$equipamento["id"]."' ORDER BY id DESC ");
			
			$tempItens = array();
			
			while($historico=mysql_fetch_array($sqlHistorico)){
				$tempItens["solicitacao_defeito"] = utf8_encode($historico["solicitacao_defeito"]);
				$tempItens["diagnostico_laudo"] = utf8_encode($historico["diagnostico_laudo"]);
				$tempItens["estado_equipamento"] = utf8_encode($historico["estado_equipamento"]);
				$tempItens["data_cadastro"] = utf8_encode($historico["dataCadastro"]);
				$tempItens["os_id"] = utf8_encode($historico["os_id"]);
				
				$json["itens"][] = $tempItens;
			}
			
		}
		
		echo json_encode($json);
	}
	
	function VerificaDescontos(){
		global $vkt_id;
		$valor = moedaBrToUsa($_POST["valor"]);
	 	
		$sql = " SELECT * FROM os_configuracao WHERE id = '$vkt_id' ";
		$rows = mysql_fetch_object(mysql_query($sql));
		
		if( $valor <= $rows->valor_total_desconto )
			echo "success";
		else
			echo "erro";
	}
	
	function checaSaldo2($cliente_id,$conta_id){
	return @mysql_fetch_object(mysql_query("
		SELECT saldo,id FROM financeiro_movimento WHERE cliente_id='$cliente_id' 
		AND 
			conta_id='$conta_id'
		AND
			`status`='1'
		ORDER BY data_movimento DESC LIMIT 1 "));
	}

	function movimenta($cliente_id,$conta_id,$movimento_id,$entrada,$saida,$tipo_movimento){
	
		$saldo = checaSaldo2($cliente_id,$conta_id);
		
		$novo_saldo = $entrada-$saida+$saldo->saldo;
		
		$calculo_aplicado = "$entrada-$saida+$saldo->saldo";
				
		if(mysql_query($trace_m="
		UPDATE financeiro_movimento SET 
			data_movimento=now(),
			data_info_movimento='".date("Y-m-d")."',
			entrada='$entrada',
			saida='$saida',
			saldo='$novo_saldo',
			movimentacao='$tipo_movimento',
			conta_id='$conta_id',
			status='1',
			id_anteiror='$saldo->id',
			saldo_anterior='$saldo->saldo',
			calculo_aplicado='$calculo_aplicado'
		WHERE
			id='$movimento_id'
		AND
			cliente_id='$cliente_id'
			")){
			return true	;	
		}else{
			return false;		
		}
		
	}
	
	function RealizaPagamento(){
		global $vkt_id;
		$dados = $_POST;
		
		$updateOS = " UPDATE os SET pago = 'sim', status_os = '$dados[executado]', data_execucao = '".dataBrToUsa($dados['dataExecucao'])."' WHERE id = '$dados[os_id]' ";
		mysql_query($updateOS);
		
		$insertFinanceiro = "INSERT INTO financeiro_movimento SET
			  cliente_id = '$vkt_id',
			  conta_id   = '".$dados['conta_id']."',
			  internauta_id = '".$dados['cliente_id']."',
			  data_vencimento	= '".dataBrToUsa($dados['dataVencimento'])."',
			  data_registro = NOW(),
			  ano_mes_referencia = '".date('Y/m')."',
			  descricao		  = '".utf8_decode($dados['descricao'])."',
			  doc			  = '".$dados['os_id']."',
			  origem_id		  = '".$dados['os_id']."',
			  forma_pagamento   = '".$dados['FormaPagamento']."',
			  valor_cadastro    = '".moedaBRToUsa($dados['ValorParcela'])."',
			  tipo              = 'receber',
			  status            = '0',
			  origem_tipo       = 'ordem_servico' ";
	    mysql_query($insertFinanceiro);
		$movID = mysql_insert_id();
		
		// financeiro_centro_has_movimento
		$sqlCentroAsMov = " INSERT INTO financeiro_centro_has_movimento SET movimento_id = '$movID', plano_id = '".$dados['centro_custo_id']."', valor = '".moedaBRToUsa($dados['ValorParcela'])."'";
		mysql_query($sqlCentroAsMov); 
				
		//financeiro_plano_has_movimento 
		$sqlPlanoAsMov = " INSERT INTO financeiro_plano_has_movimento SET movimento_id = '$movID', plano_id = '".$dados['plano_de_conta_id']."', valor = '".moedaBRToUsa($dados['ValorParcela'])."' ";
		mysql_query($sqlPlanoAsMov);
		movimenta($vkt_id,$dados['conta_id'],$movID,moedaBRToUsa($dados['ValorParcela']),0,'financeiro');
	
	}
	
	function formaPagamento(){
		
		global $vkt_id;
		
		$sql = mysql_query(" SELECT * FROM financeiro_formas_pagamento WHERE vkt_id = '$vkt_id' ");
		
		while($reg=mysql_fetch_object($sql)){
			$temp["id"] = $reg->id;
			$temp["nome"] = utf8_encode($reg->nome);
			$temp["valor_percentual"] = $reg->valor_percentual;
			$temp["valor_fixo"] = $reg->valor_fixo;
			$temp["prazo_efetivacao"] = $reg->prazo_efetivacao;
			$temp["plano_conta_id"] = $reg->plano_conta_id;
			$temp["centro_custo_id"] = $reg->centro_custo_id;
			$temp["obs"] = $reg->obs;
			$json[] = $temp;
		}
			
		echo json_encode($json);
	}