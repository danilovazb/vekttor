<?php

if($_GET['id']>0){$id=$_GET['id'];}
if($_POST['id']>0){$id=$_POST['id'];}
if($_GET['empresa1id']>0){$empresa_id=$_GET['empresa1id'];}
if($_POST['empresa1id']>0){$empresa_id=$_POST['empresa1id'];}



if($_POST['action']== 'Salvar'){
	manipulaINSS($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	excluiinss($_POST,$vkt_id);
}

if($id>0){
	
	
	$inss = mysql_fetch_object(mysql_query($t="SELECT * FROM  rh_inss WHERE id='$id'"));
	
}

if($_GET['empresa1id']>0){
	
	$cliente_fornecedor = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$_GET['empresa1id']."'"));
	$empresa=mysql_fetch_object(mysql_query($a="
		SELECT e.id as id FROM rh_empresas as e, cliente_fornecedor as cf 
		WHERE 
			e.vkt_id='$vkt_id' 
		AND 
			e.cliente_fornecedor_id='$empresa_id'
		AND
			cf.id = e.cliente_fornecedor_id
		AND
			cf.tipo='Cliente' 
		AND 
			cf.tipo_cadastro='Jurídico' 
		AND 
			e.status='1'
		LIMIT 1
	"));
	$configuracao=mysql_fetch_object(mysql_query("SELECT * FROM rh_folha_ponto_configuracao WHERE vkt_id='$vkt_id' AND empresa_id='$empresa->id' LIMIT 1"));
	if(!$configuracao){
		$dados = array(
		'empresa_id'			=>	$empresa->id,
		'dia_abertura_folha'	=>	1,
		'semana_inicio'	=>	1,
		'recibo_hora_extra'		=> 'nao'
		);
		manipularConfiguracaoFolhaPonto($dados);
	}
	$data_folha = DataBrToUsa($_GET['data']);
	$diasemana = mysql_fetch_object(mysql_query("SELECT DATE_FORMAT('".DataBrToUsa($_GET['data'])."','%w') as dia_semana"));
	$dia_anterior = mysql_fetch_object(mysql_query($t="SELECT DATE_SUB('$data_folha',INTERVAL 1 DAY) as dia_anterior"));
	$proximo_dia = mysql_fetch_object(mysql_query($t="SELECT DATE_ADD('$data_folha',INTERVAL 1 DAY) as proximo_dia"));
	
}

if($_GET['acao']=="atualiza_horas"){
	include("../../../_config.php");
	// funções base do sistema
	include("../../../_functions_base.php");
	include('_functions.php');
	atualiza_horas($_GET);
	exit();
}
?>