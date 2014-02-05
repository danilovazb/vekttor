<?php
function manipulaConfiguracao($dados){
		global $vkt_id;
		
		if(empty($dados['vkt_id'])){
			$inicio = "INSERT INTO cobranca_mensal_configuracao";
			$fim    = "";
		}else{
			$inicio = "UPDATE cobranca_mensal_configuracao";
			$fim    = "WHERE vkt_id='$dados[vkt_id]'";
		}
		
		mysql_query($t="
			$inicio
			SET
			vkt_id='$vkt_id',
			banco='$dados[banco]',
			email_envio = '$dados[email_envio]',
			nome_envio  = '$dados[nome_envio]',
			multa_atraso= '".moedaBrToUsa($dados['multa_atraso'])."',
			mora_diaria = '".moedaBrToUsa($dados[mora_diaria])."',
			instruncoes_boleto = '$dados[instruncoes_boleto]',
			dias_antecedencia  = '$dados[dias_antecedencia]',
			assunto_cobranca   = '$dados[assunto_cobranca]',
			texto_envio_cobranca = '$dados[texto_envio_cobranca]',
			assunto_contas_vencidas = '$dados[assunto_contas_vencidas]',
			texto_contas_vencidas   = '$dados[texto_contas_vencidas]',
			sms_envio_cobranca = '$dados[sms_envio_cobranca]', 
			sms_contas_vencidas = '$dados[sms_contas_vencidas]' 
			$fim");
		
}


function manipulacobrancacliente($valor,$tipo_mensalidade,$data_vencimento, $centro_custo_id,$plano_contas_id, $enviar_email,$enviar_sms,$cliente_fornecedor_id, $cobranca_mensal_cliente_id, $texto_envio_cobranca,
$sms_envio_cobranca, $sms_contas_vencidas){
	global $vkt_id;
	
	if(!$cobranca_mensal_cliente_id>0){
		$inicio = "INSERT INTO";
		$fim="";
	}else{
		$inicio = "UPDATE";
		$fim=" WHERE id='$cobranca_mensal_cliente_id'";
	}
	
	if(!isset($enviar_email)){
		$em="nao";
	}else{
		$em="sim";
	}
	
	if(!isset($enviar_sms)){
		$es="nao";
	}else{
		$es="sim";
	}
	
	mysql_query($t="$inicio
		cobranca_mensal_clientes
		SET
		vkt_id='$vkt_id',
		cliente_fornecedor_id='$cliente_fornecedor_id',
		valor          ='".moedaBrToUsa($valor)."',
		tipo_mensalidade='$tipo_mensalidade',
		data_vencimento='".DataBrToUsa($data_vencimento)."',
		centro_custo_id='$centro_custo_id',
		plano_contas_id='$plano_contas_id',
		enviar_email   = '$em',
		enviar_sms     = '$es',
		descricao_cobranca = '$texto_envio_cobranca'
		
		$fim
		");

		
}

function excluiConfiguracaoCliente($id){
	mysql_query($t="DELETE FROM cobranca_mensal_clientes WHERE id='$id'");
	//echo $t;
}
?>