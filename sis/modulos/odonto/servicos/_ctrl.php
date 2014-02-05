<?php

if($_POST['action']== 'Salvar'){
	manipulaServico($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	excluiServico($_POST,$vkt_id);
}

if($_POST['action']=='realizar_importacao'){

	realizar_importacao($_POST);
}


if($_GET['id'] > 0){
	
	$id = $_GET['id'];
	
	$servico = mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id='$id'"));
}

//-----------------------------------------------------
if($_POST['actionGrupo']=="Salvar"){
	//alert("oi");
	manipulaGrupo($_POST);
	
}
if($_POST['actionGrupo']=="Excluir"){
	//alert("oi");
	ExcluirGrupo($_POST);
	
}



if($_GET['grupo_id']>0){
	//alert("oi");
	$grupo = mysql_fetch_object(mysql_query("SELECT * FROM servico_grupo WHERE id='".$_GET['grupo_id']."'"));
}

$convenios = mysql_query("SELECT *, oc.id as convenio_id FROM odontologo_convenio oc, cliente_fornecedor cf
								WHERE
								oc.vkt_id='$vkt_id' AND
								oc.cliente_fornecedor_id = cf.id
								
								");
	echo mysql_error();

//
$displayund="none";
?>