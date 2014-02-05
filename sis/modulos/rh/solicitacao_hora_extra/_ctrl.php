<?php

if($_GET['id']>0){$id=$_GET['id'];}
if($_POST['id']>0){$id=$_POST['id'];}

if($_POST['action']== 'Salvar'){
	manipula_solicitacao_hora_extra($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	exclui_hora_extra($_POST['id']);
}

if($id>0){
	
	
	$inss = mysql_fetch_object(mysql_query($t="SELECT * FROM  rh_inss WHERE id='$id'"));
	
}

if($id>0){
	$solicitacao_hora_extra = mysql_fetch_object(mysql_query($t="
	SELECT she.*, she.id as she_id FROM 
		rh_solicitacao_hora_extra she,
		cliente_fornecedor cf,
		rh_funcionario rh_f 
		WHERE 
		she.id='$id' AND
		she.vkt_id='$vkt_id' AND
		she.empresa_id = cf.id AND
		she.funcionario_id=rh_f.id
		"));
	$funcionarios = selecionaFuncionario($solicitacao_hora_extra->empresa_id,$solicitacao_hora_extra->funcionario_id);
}

if($_GET['action']=='SelFuncionario'){
	
	include("../../../_config.php");
	// funções base do sistema
	include("../../../_functions_base.php");
	// funções do modulo empreendimento
	include("_functions.php");
	
	$funcionarios = selecionaFuncionario($_GET['empresa_id']);
	echo $funcionarios;
	exit();
}
$q= mysql_query($t="SELECT *, cf.id as cliente_forencedor_id FROM 
		  rh_empresas re,
		  cliente_fornecedor cf 
		  WHERE 
		  re.cliente_fornecedor_id = cf.id AND
		  cf.tipo='Cliente' AND 
		  cf.tipo_cadastro='Jurídico' AND 
		  re.vkt_id ='$vkt_id' AND 
		  re.status='1' 
		  ORDER BY cf.razao_social");
?>