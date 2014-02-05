<?php

if($_GET['id']>0){$id=$_GET['id'];}
if($_POST['id']>0){$id=$_POST['id'];}

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
	
	$data_folha = DataBrToUsa($_GET['data']);
	
	$diasemana = mysql_fetch_object(mysql_query("SELECT DATE_FORMAT('".DataBrToUsa($_GET['data'])."','%w') as dia_semana"));
	
	
	
	//alert($diasemana);
	$dia_anterior = mysql_fetch_object(mysql_query($t="SELECT DATE_SUB('$data_folha',INTERVAL 1 DAY) as dia_anterior"));
	
	//$data_folha = mysql_fetch_object(mysql_query($t="SELECT DATE_ADD('$data_folha',INTERVAL 1 DAY) as data_folha"));
	
	$proximo_dia = mysql_fetch_object(mysql_query($t="SELECT DATE_ADD('$data_folha',INTERVAL 1 DAY) as proximo_dia"));
	
	//$data_folha = $data_folha->proximo_dia;
	
}

?>