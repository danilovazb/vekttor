<?
if($_GET['empresa_id']>0){$empresa_id=$_GET['empresa_id'];}
if($_POST['empresa_id']>0){$empresa_id=$_POST['empresa_id'];}


if($_POST['action']=="Salvar"){
	manipularConfiguracaoFolhaPonto($_POST);
}


if($empresa_id>0){
	$empresa=mysql_fetch_object(mysql_query($a="
		SELECT e.id as id FROM rh_empresas as e, cliente_fornecedor as cf 
		WHERE 
			e.vkt_id='$vkt_id' 
		AND 
			e.id='$empresa_id'
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
	
}