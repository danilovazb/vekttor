<?php

if($_GET['id']>0){$id=$_GET['id'];}
if($_POST['id']>0){$id=$_POST['id'];}

if($_POST['action']== 'Salvar'){
	manipulaLicencaFuncionario($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	excluiLicenca($_POST,$vkt_id);
}

if($_GET['empresa1id']>0){
		
	$empresa = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$_GET['empresa1id']."'"));
	
}


if($id>0){
	
	
	$licenca_funcionario = mysql_fetch_object(mysql_query("SELECT * FROM rh_licencas_funcionarios WHERE id='$id'"));
	$funcionario = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_funcionario WHERE id='$licenca_funcionario->funcionario_id'"));
	$empresa = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='$funcionario->empresa_id'"));
	echo $t."<br>";
}

?>