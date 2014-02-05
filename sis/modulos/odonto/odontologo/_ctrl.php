<?php
if($_POST['action']=="Salvar"){
	$usuario_id = manipulaUsuario($_POST);
	$cliente_fornecedor = ManipulaClienteFornecedor($_POST,$usuario_id);
	manipulaOdontologo($_POST,$usuario_id,$cliente_fornecedor);
}

if($_POST['action']=="Excluir"){
	ExcluiOdontologo($_POST);
}

if($_GET['id']>0){
	$odontologo             = mysql_fetch_object(mysql_query($t="SELECT *,oc.id as oc_id, cf.id as cf_id FROM 
		odontologo_odontologo oc,
		cliente_fornecedor cf,
		usuario u
		WHERE
		oc.cliente_fornecedor_id = cf.id AND
		oc.usuario_id            = u.id AND
		oc.id = '".$_GET['id']."' AND
		oc.vkt_id = '$vkt_id'"));
		//echo $t;
}
?>