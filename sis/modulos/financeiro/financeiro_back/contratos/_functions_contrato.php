<?
/*

cliente_fornecedor_id
cliente
nome
numero
valor_total
valor_entrada
parcelas
valor_parcela
valor_total_pago
parcelas_pagas
valor_parcela_paga
data_proxima_parcela
parcela_tipo
centro_custo_id
plano_de_conta_id

*/

function gerencia_contrato($contrato_id,$campos,$action){
	global $vkt_id;
	//pr($campos);
	$tabela = "financeiro_contratos";
	if($contrato_id<1){
		$sql_inicio = "INSERT INTO $tabela ";
	}else{
		$sql_inicio = "UPDATE  $tabela ";
		$sql_fim = " WHERE id='$contrato_id' AND  vkt_id	='$vkt_id' ";
	}
	if($action=='DELETE'&&$contrato_id>0){
		$sql_inicio = "DELETE FROM $tabela ";
	}else{
		$sql_campos = " SET
						vkt_id	='$vkt_id',
		cliente_fornecedor_id	= '{$campos['cliente_fornecedor_id']}',
					centro_id	= '{$campos['centro_custo_id']}',
					plano_id	= '{$campos['plano_de_conta_id']}',
						nome	= '{$campos['nome']}',
						numero	= '{$campos['numero']}',
					parcelas	= '{$campos['parcelas']}',
				parcelas_pagas	= '{$campos['parcelas_pagas']}',
				valor_parcela	= '".moedaBrToUsa($campos['valor_parcela'])."',
			tipo_de_cobranca	= '{$campos['parcela_tipo']}',
				valor_contrato	= '".moedaBrToUsa($campos['valor_total'])."',
		valor_pago_em_parcelas 	= '".moedaBrToUsa($campos['valor_total_pago'])."',
				valor_entrada	= '".moedaBrToUsa($campos['valor_entrada'])."',
				data_pagamento	= '".dataBrToUsa($campos['data_proxima_parcela'])."'
		";
	}
	
	
	mysql_query($sql_inicio.$sql_campos.$sql_fim);
	if($contrato_id<1){ 
		$contrato_id = mysql_insert_id();
	}else{
		contrato_movimento_deleta($contrato_id);
	}
	$quantidade_de_parcelas_pendentes = $campos['parcelas']-$campos['parcelas_pagas'];
	calcura_parcelas_a_pagar($contrato_id,$quantidade_de_parcelas_pendentes,dataBrToUsa($campos['data_proxima_parcela']));
}

function calcura_parcelas_a_pagar($contrato_id,$parcelas,$data_proxima_parcela){
	$contrato = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_contratos WHERE id='$contrato_id'"));
	
	for($i=0;$i<$parcelas;$i++){
		$proxima_parcela = mysql_result(mysql_query($t="SELECT DATE_ADD('$data_proxima_parcela', INTERVAL $i MONTH ) "),0,0);
		echo "($proxima_parcela)";
		$mes_ano_proxima_parcela = mysql_result(mysql_query("SELECT date_format(DATE_ADD('$data_proxima_parcela', INTERVAL $i MONTH ), '%m/%Y') "),0,0);
		cadastra_movimento(array(
						'internauta_id'	=>$contrato->cliente_fornecedor_id,
					'data_vencimento'	=>$proxima_parcela,
					'ano_mes_referencia'=>$mes_ano_proxima_parcela,
							'descricao'	=>$contrato->nome." ".($contrato->parcelas_pagas+$i+1)."/$contrato->parcelas",
								'nota'	=>'',
								'doc'	=>$contrato_id,
					'forma_pagamento'	=>0,
						'origem_tipo'	=>'Contrato',
							'origem_id'	=>$contrato_id,
						'autorizado'	=>'0',
							'conta_id'	=>'0',
					'valor_cadastro'	=> $contrato->valor_parcela,
								'tipo'	=>'pagar',
							'extorno'	=>'0',
						'transferencia'	=>'0',
							'centro_id'	=>$contrato->centro_id ,
							'plano_id'	=>$contrato->plano_id ,
							));
	}
	
	
}

function cadastra_movimento($campos){
	global $vkt_id;
	mysql_query($t="INSERT INTO financeiro_movimento SET
							cliente_id	='$vkt_id',
					internauta_id		='".$campos['internauta_id']."',
						data_registro	=now(),
					data_vencimento		='".$campos['data_vencimento']."',
					ano_mes_referencia	='".$campos['ano_mes_referencia']."',
							descricao	='".$campos['descricao']."',
								nota	='".$campos['nota']."',
									doc	='".$campos['doc']."',
						forma_pagamento	='".$campos['forma_pagamento']."',
							origem_tipo	='".$campos['origem_tipo']."',
							origem_id	='".$campos['origem_id']."',
							autorizado	='".$campos['autorizado']."',
							conta_id	='".$campos['conta_id']."', 
						valor_cadastro	='".$campos['valor_cadastro']."',
								tipo	='".$campos['tipo']."',
								extorno	='".$campos['extorno']."',
						transferencia	='".$campos['transferencia']."'");
	$movimento_id = mysql_insert_id();
	
	mysql_query("INSERT INTO financeiro_centro_has_movimento SET movimento_id='$movimento_id', plano_id='".$campos['centro_id']."', valor='".$campos['valor_cadastro']."'");
	
	mysql_query("INSERT INTO financeiro_plano_has_movimento SET movimento_id='$movimento_id', plano_id='".$campos['plano_id']."', valor='".$campos['valor_cadastro']."'");
}

function contrato_movimento_deleta($contrato_id){
	global $vkt_id;
	
	$q =mysql_query("SELECT * FROM financeiro_movimento WHERE origem_id='$contrato_id' AND origem_tipo='Contrato' AND cliente_id	='$vkt_id' AND status!='2'");
	while($r= mysql_fetch_object($q)){
		mysql_query("DELETE FROM financeiro_plano_has_movimento WHERE movimento_id ='$r->id'");
		mysql_query("DELETE FROM financeiro_centro_has_movimento WHERE movimento_id ='$r->id'");
		mysql_query("DELETE FROM financeiro_movimento WHERE id='$r->id'");		
	}
}



function conta_movimento_de_contrato($contrato_id){
	global $vkt_id;
	
	
	$r = mysql_fetch_object(mysql_query("SELECT  COUNT(*) as parcelas,sum(saida) as total FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND  origem_tipo='Contrato' AND origem_id='$contrato_id' AND status='1'"));
	$dados['parcelas']= $r->parcelas;
	$dados['total']= $r->total;
	
	return $dados;
}

?>