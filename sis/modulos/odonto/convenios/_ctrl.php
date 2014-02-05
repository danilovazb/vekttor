<?php
if($_POST['action']=="Salvar"){
	manipulaFornecedor($_POST);
}

if($_POST['action']=="Excluir"){
	ExcluirFornecedor($_POST['cf_id']);
}

if($_GET['cf_id']>0){
	$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id=".$_GET['cf_id']));
	$odonto             = mysql_fetch_object(mysql_query("SELECT * FROM odontologo_convenio WHERE cliente_fornecedor_id=".$_GET['cf_id']));
}
?>