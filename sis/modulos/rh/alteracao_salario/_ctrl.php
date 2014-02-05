<?php

if($_POST['action']== 'Salvar'){
	manipulaSalarios($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	excluiCargosSalarios($_POST,$vkt_id);
}

if($_GET['id'] > 0){
	
	$id = $_GET['id'];
	
	$cargo_salario = mysql_fetch_object(mysql_query("SELECT * FROM cargo_salario WHERE id='$id'"));
}

if($_GET['empresaid']>0){
	$empresa = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$_GET['empresaid']."'"));
}

if($id>0){
	
	
	$registro = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$id' AND vkt_id='$vkt_id'"));
	$empresa = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$registro->empresa_id."'"));
	$salario_atual = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_alteracao_salario WHERE vkt_id='$vkt_id' AND funcionario_id='".$registro->id."' ORDER BY id DESC LIMIT 1"));

	if(empty($salario_atual->salario)){
		$salario_atual = $registro->salario;
	}else{
		$salario_atual = $salario_atual->salario;
	}
}

?>