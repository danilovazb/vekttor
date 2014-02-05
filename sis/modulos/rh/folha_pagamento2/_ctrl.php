<?php
if($_GET['folha_id']>0){$folha_id=$_GET['folha_id'];}
if($_POST['folha_id']>0){$folha_id=$_POST['folha_id'];}
if($_GET['empresa_id']>0){$empresa_id=$_GET['empresa_id'];}
if($_POST['empresa_id']>0){$empresa_id=$_POST['empresa_id'];}
if($_GET['funcionario_id']>0){$funcionario_id=$_GET['funcionario_id'];}
if($_POST['action']=='Salvar'){
	$folhaPagamento = new FolhadePagamento;
	$folha_id = $folhaPagamento->criafolha($_POST);
	$funcionarios = $folhaPagamento->FuncionariosEmpresa($_POST['empresa_id'],'');
	$folhaPagamento->adicionaFuncionariosFolha($folha_id,$funcionarios);
	$folhaPagamento->selecionaEventosAdicionaisFuncionarios($folha_id,$funcionarios);
	$folhaPagamento->selecionaLicencasFuncionarios($folha_id,$funcionarios);
	$folhaPagamento->totais($folha_id,$funcionarios);
	$folhaPagamento->EventosCondicionaisFuncionarios($folha_id,$funcionarios);
	unset($folhaPagamento);
	echo "<script>location.href='?tela_id=586&folha_id=$folha_id'
    </ script>";
}

if($_POST['action']=='Excluir'){
	excluiFolha($_POST);
}
if($_GET['action']=='atualizaFolha' && intval($_GET['folha_funcionario_id'])>0){
	
	$folhaPagamento = new FolhadePagamento();
	
	$funcionarios = $folhaPagamento->FuncionariosEmpresa(0,$_GET['funcionario_id']);
	$folhaPagamento->EventosObrigatorios($_GET);
	$folhaPagamento->EventosCondicionaisFuncionarios($_GET['folha_id'],$funcionarios);
	$folhaPagamento->totais($_GET['folha_id'],$funcionarios);
	
}

if($_GET['action']=='excluirFolha'&&$_GET['folha_id_deletar']>0&&$_GET['empresa_id']>0){
	excluirFolha($_GET['folha_id_deletar'],$_GET['empresa_id']);
	echo "<script>location.href='?tela_id=585&empresa_id=".$_GET['empresa_id']."'</script>";
}

if($_GET['action']=='confirmarFolha'&&$_GET['folha_id_confirmar']>0&&$_GET['empresa_id']>0){
	confirmarFolha($_GET['folha_id_confirmar'],$_GET['empresa_id']);
	echo "<script>location.href='?tela_id=585&empresa_id=".$_GET['empresa_id']."'</script>";
}

if($_POST['action']=='atualizaEventoFuncionario'){
	atualizaEventoFuncionario($_POST);
	exit();
}

if($_POST['action']=='CalculaDescontoCompartilhado'){
	$folhaPagamento = new FolhadePagamento();
	$result = $folhaPagamento->CalculaDescontoCompartilhado($_POST);
	echo $result;
	//exit();
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
	$folha=mysql_fetch_object(mysql_query("SELECT * FROM rh_folha WHERE id='".$folha_id."'"));
	
	$empresa=mysql_fetch_object(mysql_query($a="
	SELECT 
		re.id as empresa_id, cf.razao_social as razao_social, cf.*
	FROM 
		rh_empresas re,
		cliente_fornecedor cf
	WHERE re.cliente_fornecedor_id='".$folha->empresa_id."' AND vkt_id='".$vkt_id."' AND re.cliente_fornecedor_id=cf.id "));
}
if($_GET['acao']="abreEventos"){
	$funcionario_eventos_q=mq($a_query="SELECT * FROM rh_folha_funcionarios_eventos WHERE vkt_id='$vkt_id' AND folha_id='$folha_id' AND funcionario_id='$funcionario_id' AND tipo='adicional' AND vencimento_ou_desconto='vencimento' ");
	$funcionario=mf(mq($jaime_fresco="SELECT * FROM rh_funcionario WHERE vkt_id='$vkt_id' AND id='$funcionario_id' LIMIT 1 "));
	$folha_funcionario=mf(mq($jaime_fresco="SELECT * FROM rh_folha_funcionario WHERE vkt_id='$vkt_id' AND folha_id='$folha_id' AND funcionario_id='$funcionario_id' LIMIT 1 "));
	$folha=mf(mq($jaime_fresco="SELECT * FROM rh_folha WHERE vkt_id='$vkt_id' AND id='$folha_id'"));
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