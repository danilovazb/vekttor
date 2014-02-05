	<?
if($_GET['folha_id']>0){$folha_id=$_GET['folha_id'];}
if($_POST['folha_id']>0){$folha_id=$_POST['folha_id'];}
if($_GET['empresa_id']>0){$empresa_id=$_GET['empresa_id'];}
if($_POST['empresa_id']>0){$empresa_id=$_POST['empresa_id'];}

if($_POST['action']=='Salvar'){
	adicionaFolha($_POST);
}

if($_POST['action']=='Excluir'){
	excluiFolha($_POST);
}
if($_GET['action']=='atualizaFolha' && intval($_GET['folha_funcionario_id'])>0){
	atualizaFolhaDePagamento($_GET);
	exit();
}

if($_GET['action']=='excluirFolha'&&$_GET['folha_id_deletar']>0&&$_GET['empresa_id']>0){
	excluirFolha($_GET['folha_id_deletar'],$_GET['empresa_id']);
}

if($_GET['action']=='confirmarFolha'&&$_GET['folha_id_confirmar']>0&&$_GET['empresa_id']>0){
	confirmarFolha($_GET['folha_id_confirmar'],$_GET['empresa_id']);
}

if($empresa_id>0){
	$empresa=mysql_fetch_object(mysql_query($a="
	SELECT 
		cf.id as empresa_id, cf.razao_social as razao_social
	FROM 
		rh_empresas re,
		cliente_fornecedor cf
	WHERE cf.id='".$empresa_id."' AND vkt_id='".$vkt_id."' AND re.cliente_fornecedor_id=cf.id "));
}

if($folha_id>0){
	$folha=mysql_fetch_object(mysql_query("SELECT * FROM rh_folha_empresa WHERE id='".$folha_id."'"));
	
	$empresa=mysql_fetch_object(mysql_query($a="
	SELECT 
		re.id as empresa_id, cf.razao_social as razao_social, cf.*
	FROM 
		rh_empresas re,
		cliente_fornecedor cf
	WHERE re.cliente_fornecedor_id='".$folha->empresa_id."' AND vkt_id='".$vkt_id."' AND re.cliente_fornecedor_id=cf.id "));
}
$link_alteracao[439]=441;
$link_alteracao[445]=446;
$link_exclusao[441]=439;
$link_exclusao[446]=445;
if($folha->status=='em aberto'||$tela->id==446){
	$d="";
}else{
	$d="disabled='disabled'";
}
if($tela->id!=446){
	$permite_excluir="disabled='disabled'";
}




