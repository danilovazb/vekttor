<?php

if($_POST['action']== 'Salvar'){
	if(!$_POST['id']>0){
		cadastroCobranca($_POST);
	}else{
		atualizaCobranca($_POST);
	}
}

if($_POST['action']== 'Excluir'){
	excluiCobranca($_POST['id']);
}

if($_GET['id']>0){
	
	$id=$_GET['id'];
	
	$cobranca = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_cobranca_empresas WHERE id='$id' AND vkt_id='$vkt_id'"));

	$cliente_fornecedor = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$cobranca->cliente_fornecedor_id."'"));
	
	if($cobranca->situacao=='1'){
		$disabled="disabled='disabled'";
	}
}

?>