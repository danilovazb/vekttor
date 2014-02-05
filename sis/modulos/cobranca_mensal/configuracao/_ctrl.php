<?php

if($_POST['salva_formulario_contrato_cliente']>0){
	
	manipulaConfiguracao($_POST);
	
}


if(($_POST['action2']=="salvar_cliente")||($_POST["actionGrupo"]=="Salvar")||($_POST["actionGrupo"]=="Excluir")){

	include("modulos/administrativo/clientes/_functions.php");
	include("modulos/administrativo/clientes/_ctrl.php");
	
	//echo $cliente_id."<br>";
	manipulacobrancacliente($_POST["j_valor"],$_POST["j_tipo_mensalidade"],
		$_POST['j_data_vencimento'], $_POST["j_centro_custo_id"], 
		$_POST["j_plano_contas_id"], $_POST["enviar_email"],$_POST["enviar_sms"],$cliente_id, $_POST["cobranca_mensal_cliente_id"], $_POST['texto_envio_cobranca'],
		$_POST["sms_envio_cobranca"], $_POST["sms_contas_vencidas"]);
	
	if(isset($exclui)){
		//echo "oi3";
		excluiConfiguracaoCliente($_POST['cobranca_mensal_cliente_id']);
	}
}

if($_POST["action"]=="Remover Configuração da Conta"){
	excluiConfiguracaoCliente($_POST['cobranca_mensal_cliente_id']);
}

$configuracao_cobranca = mysql_fetch_object(mysql_query($t="SELECT * FROM cobranca_mensal_configuracao WHERE vkt_id='$vkt_id'"));

?>