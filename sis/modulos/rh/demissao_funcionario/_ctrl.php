<?php

if($_POST['action']== 'Salvar'){
	manipulaDemissao($_POST,$vkt_id);
}

if($_POST['action']== 'Cancelar Demissão'){
	excluiDemissao($_POST,$vkt_id);
}

if($_GET['id'] > 0){
	
	$id = $_GET['id'];
	
	$cargo_salario = mysql_fetch_object(mysql_query("SELECT * FROM cargo_salario WHERE id='$id'"));
}

if($_GET['empresaid']>0){
	$empresa = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$_GET['empresaid']."'"));
}

if($id>0){
	$mes_atual = date('m');
	
	$registro = mysql_fetch_object(mysql_query($ty="SELECT * FROM rh_funcionario WHERE id='$id' AND vkt_id='$vkt_id'"));
	$empresa = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$registro->empresa_id."'"));
	
	$funcionario_ferias = (mysql_query(" SELECT * FROM rh_ferias WHERE vkt_id = '$vkt_id' AND funcionario_id = '".$registro->id."' AND empresa_id = '".$empresa->id."' AND MONTH(data_inicio) = '$mes_atual' "));
	$fun_ferias = mysql_num_rows($funcionario_ferias);
	
	$demissao = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_funcionario_demitidos WHERE vkt_id='$vkt_id' AND funcionario_id='".$registro->id."' AND empresa_id='$empresa->id' ORDER BY id DESC LIMIT 1"));
	
}

?>